<?php

declare(strict_types=1);

namespace Vanilo\Admin\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Konekt\AppShell\Http\Controllers\BaseController;
use Vanilo\Admin\Contracts\Requests\CreateVideo;
use Vanilo\Admin\Contracts\Requests\UpdateVideo;
use Vanilo\Video\Contracts\Video;

class VideoController extends BaseController
{
    public function store(CreateVideo $request): RedirectResponse
    {
        try {
            $model = $request->getFor();
            $model->videos()->create($request->validated());

            flash()->success(__('Video :title has been added', ['title' => $model->title]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect()->back();
    }

    public function show(Video $video): View
    {
        return view('vanilo::video.show', [
            'video' => $video,
        ]);
    }

    public function edit(Video $video): View
    {
        return view('vanilo::video.edit', [
            'video' => $video,
        ]);
    }

    public function update(UpdateVideo $request, Video $video): RedirectResponse
    {
        try {
            $video->update($request->validated());

            flash()->success(__('Video :title has been updated', ['title' => $video->title]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect()->back();
    }

    public function destroy(Video $video): RedirectResponse
    {
        try {
            $title = $video->title;
            $video->delete();

            flash()->warning(__('Video :title has been deleted', ['title' => $title]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect()->back();
    }
}
