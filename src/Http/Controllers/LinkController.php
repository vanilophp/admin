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
use Vanilo\Links\Models\LinkTypeProxy;
use Vanilo\Links\Query\Establish;
use Vanilo\Links\Query\Get;

class LinkController extends BaseController
{
    public function create(CreateLinkForm $request)
    {
        $source = $request->getSourceModel();
        $existingGroups = [];
        foreach ($types = LinkTypeProxy::choices(false, true) as $slug => $name) {
            if ($group = Get::the($slug)->groups()->of($source)->first()) {
                $existingGroups[$slug] = [
                    'omnidirectional' => null === $group->root_item_id,
                ];
            }
        }

        return view('vanilo::link.create', [
            'sourceModel' => $source,
            'linkTypes' => $types,
            'existingGroups' => $existingGroups,
        ]);
    }

    public function store(CreateLink $request)
    {
        $source = $request->getSourceModel();
        try {
            $establishALinkBetweenSource = Establish::a($request->getLinkType())->link()->between($source);
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

        return redirect()->to($request->urlOfModel($source));
    }

    public function destroy(LinkGroupItem $linkGroupItem)
    {
        $linkGroupItem->delete();
        flash()->success(__('The link has been deleted.'));

        return redirect()->back();
    }
}
