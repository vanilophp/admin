<?php $media = $model->getMedia($collection ?? 'default') ?>

<x-appshell::card>
    <x-slot:title>
        {{ __('Images') }}
        <x-appshell::badge variant="secondary">{{ $media->count() }}</x-appshell::badge>
    </x-slot:title>

    @if($media->isNotEmpty())
        <div class="row">
        @foreach($media as $medium)
            <div class="col col-md-3 mb-3">
                <img class="img-thumbnail" src="{{ $medium->getUrl('thumbnail') }}" alt="{{ $medium->name }}">
            </div>
        @endforeach
        </div>
    @else
        <x-appshell::alert variant="secondary">{{ __('No image') }}</x-appshell::alert>
    @endif
</x-appshell::card>
