<?php

declare(strict_types=1);

/**
 * Contains the LinkController class.
 *
 * @copyright   Copyright (c) 2024 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2024-05-29
 *
 */

namespace Vanilo\Admin\Http\Controllers;

use Illuminate\Database\UniqueConstraintViolationException;
use Konekt\AppShell\Http\Controllers\BaseController;
use Vanilo\Admin\Contracts\Requests\CreateLink;
use Vanilo\Admin\Contracts\Requests\CreateLinkForm;
use Vanilo\Links\Contracts\LinkGroupItem;
use Vanilo\Links\Models\LinkGroupItemProxy;
use Vanilo\Links\Models\LinkTypeProxy;
use Vanilo\Links\Query\Establish;
use Vanilo\Links\Query\Get;

class LinkController extends BaseController
{
    public function create(CreateLinkForm $request)
    {
        if ($request->wantsToExtendAnExistingLinkGroup()) {
            $source = null;
            $desiredGroup = $request->getDesiredLinkGroup();
            $existingGroups[$desiredGroup->type->slug] = ['omnidirectional' => null === $desiredGroup->root_item_id];
            $types = null;
        } else {
            $desiredGroup = null;
            $source = $request->getSourceModel();
            $existingGroups = [];
            foreach ($types = LinkTypeProxy::choices(false, true) as $slug => $name) {
                if ($group = Get::the($slug)->groups()->of($source)->first()) {
                    $existingGroups[$slug] = [
                        'omnidirectional' => null === $group->root_item_id,
                    ];
                }
            }
        }

        return view('vanilo::link.create', [
            'sourceModel' => $source,
            'linkTypes' => $types,
            'desiredGroup' => $desiredGroup,
            'existingGroups' => $existingGroups,
        ]);
    }

    public function store(CreateLink $request)
    {
        if ($request->wantsToAddToAnExistingGroup()) {
            $target = $request->getTargetModel();
            $group = $request->getDesiredLinkGroup();
            try {
                LinkGroupItemProxy::create([
                    'link_group_id' => $group->id,
                    'linkable_id' => $target->id,
                    'linkable_type' => morph_type_of($target),
                ]);
            } catch (UniqueConstraintViolationException $e) {
                flash()->error(
                    __(
                        ':product is already part of the selected link group',
                        [
                            'product' => $target->name,
                        ]
                    )
                );
            }

            return redirect()->to(admin_link_to($target));
        }

        $source = $request->getSourceModel();
        try {
            $establishALinkBetweenSource = Establish::a($request->getLinkType())->new()->link()->between($source);
            if ($request->wantsUnidirectionalLink()) {
                $establishALinkBetweenSource->unidirectional();
            }
            $establishALinkBetweenSource->and($request->getTargetModel());
        } catch (UniqueConstraintViolationException $e) {
            flash()->error(
                __(
                    'The :type link between :product1 and :product2 already exists',
                    [
                        'type' => $request->getLinkType(),
                        'product1' => $source->name,
                        'product2' => $request->getTargetModel()->name,
                    ]
                )
            );
        }

        return redirect()->to(admin_link_to($source));
    }

    public function destroy(LinkGroupItem $linkGroupItem)
    {
        $group = $linkGroupItem->group;
        if ($group->root_item_id === $linkGroupItem->id) {
            $group->update(['root_item_id' => null]);
        }
        $linkGroupItem->delete();
        if ($group?->items->isEmpty() || 1 === $group?->items->count()) {
            $group->delete();
        }

        flash()->success(__('The link has been deleted.'));

        return redirect()->back();
    }
}
