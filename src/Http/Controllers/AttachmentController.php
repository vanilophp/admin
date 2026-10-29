<?php

declare(strict_types=1);

/**
 * Contains the AttachmentController class.
 *
 * @copyright   Copyright (c) 2026 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2026-10-29
 *
 */

namespace Vanilo\Admin\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Konekt\AppShell\Http\Controllers\BaseController;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Vanilo\Admin\Contracts\Requests\CreateAttachment;

class AttachmentController extends BaseController
{
    private const string COLLECTION_NAME = 'attachments';

    public function store(CreateAttachment $request): RedirectResponse
    {
        $model = $request->getFor();
        if (null === $model || !method_exists($model, 'addAttachment')) {
            abort(404);
        }

        try {
            foreach ($request->file('attachments', []) as $file) {
                $model->addAttachment($file);
            }
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        flash()->success(__('Attachments have been added successfully'));

        return redirect()->back();
    }

    public function destroy(Media $attachment): RedirectResponse
    {
        if (self::COLLECTION_NAME !== $attachment->collection_name) {
            abort(404);
        }

        try {
            $name = $attachment->file_name;
            $attachment->delete();

            flash()->warning(__('Attachment :name has been deleted', ['name' => $name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));
        }

        return redirect()->back();
    }
}
