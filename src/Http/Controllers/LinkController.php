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

use Konekt\AppShell\Http\Controllers\BaseController;
use Vanilo\Admin\Contracts\Requests\CreateLink;
use Vanilo\Admin\Contracts\Requests\CreateLinkForm;
use Vanilo\Links\Contracts\LinkGroupItem;
use Vanilo\Links\Models\LinkTypeProxy;
use Vanilo\Links\Query\Establish;

class LinkController extends BaseController
{
    public function create(CreateLinkForm $request)
    {
        return view('vanilo::link.create', [
            'sourceModel' => $request->getSourceModel(),
            'linkTypes' => LinkTypeProxy::choices(false, true),
        ]);
    }

    public function store(CreateLink $request)
    {
        $source = $request->getSourceModel();
        Establish::a($request->getLinkType())
            ->link()
            ->between($source)
            ->and($request->getTargetModel());

        return redirect()->to($request->urlOfModel($source));
    }

    public function destroy(LinkGroupItem $linkGroupItem)
    {
        $linkGroupItem->delete();
        flash()->success(__('The link has been deleted.'));

        return redirect()->back();
    }
}
