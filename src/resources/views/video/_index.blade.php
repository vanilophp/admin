<?php $videos = $model->videos ?>

<x-appshell::card>
    <x-slot:title>
        {{ __('Videos') }}
        <x-appshell::badge variant="secondary">{{ $videos?->count() ?? 0 }}</x-appshell::badge>
    </x-slot:title>

    @if($videos?->isNotEmpty())
        <div class="row">
            @foreach($videos as $video)
                <div class="text-sm-left text-info fw-bold">
                    <a href="{{ route('vanilo.admin.video.show', $video) }}" title="{{ $video->title }}" class="small text-secondary"
                       target="_blank">{{ $video->title }} {!! icon('link') !!}</a>
                </div>
            @endforeach
        </div>
    @else
        <x-appshell::alert variant="secondary">{{ __('No video') }}</x-appshell::alert>
    @endif
</x-appshell::card>
