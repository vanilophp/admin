<?php

declare(strict_types=1);
/**
 * Contains the MediaController class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-05-13
 *
 */

namespace Vanilo\Admin\Http\Controllers;

use Konekt\AppShell\Http\Controllers\BaseController;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Vanilo\Admin\Contracts\Requests\CreateMedia;

class MediaController extends BaseController
{
    private const DEFAULT_COLLECTION_NAME = 'default';

    public function update(Media $medium)
    {
        $model = $medium->model;
        $sortOrder = [];
        foreach ($model->getMedia(self::DEFAULT_COLLECTION_NAME) as $mediaItem) {
            if ($medium->id !== $mediaItem->id) {
                $mediaItem->forgetCustomProperty('isPrimary');
                $mediaItem->save();
                $sortOrder[] = $mediaItem->id;
            }
        }

        $medium->setCustomProperty('isPrimary', true);
        $medium->save();
        Media::setNewOrder([$medium->id, ...$sortOrder]);

        flash()->success(__('Primary image has been updated'));

        return back();
    }

    public function destroy(Media $medium)
    {
        try {
            $name = $medium->name;
            $medium->delete();

            flash()->warning(__('Media :name has been deleted', ['name' => $name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        // redirect to the previous page
        return redirect()->intended(url()->previous());
    }

    public function store(CreateMedia $request)
    {
        $model = $request->getFor();

        $model->addMultipleMediaFromRequest(['images'])->each(function ($fileAdder) {
            $fileAdder->toMediaCollection(self::DEFAULT_COLLECTION_NAME);
        });

        return back()->with('success', __('Images have been added successfully'));
    }
}
