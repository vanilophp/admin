@can('list videos')
<?php $videos = $model->videos ?>

<x-appshell::card>
    <x-slot:title>
        {{ __('Videos') }}
        <x-appshell::badge variant="secondary">{{ $videos?->count() ?? 0 }}</x-appshell::badge>
    </x-slot:title>

    @if($videos?->isNotEmpty())
        <div class="row">
            <?php /** @var \Vanilo\Video\Contracts\Video $video */ ?>
            @foreach($videos as $video)
                <a class="col" href="{{ $video->getVideoUrl() ?? '#' }}" target="_blank">
                    <img src="{{ $video->getThumbnail()->url ?? 'data:;base64,iVBORw0KGgoAAAANSUhEUgAAAPoAAAD6AQMAAACyIsh+AAAAA1BMVEWSj4+Y8UtxAAAAHklEQVRo3u3BAQEAAACCoP6vbojAAAAAAAAAAICwAyA6AAFG0xi/AAAAAElFTkSuQmCC' }}"
                         class="img-thumbnail" style="height: 4rem; width: auto;"
                         title="{{ $video->getTitle() }}"
                    />
                </a>
            @endforeach
        </div>
    @else
        <x-appshell::alert variant="secondary">{{ __('No video') }}</x-appshell::alert>
    @endif
</x-appshell::card>
@endcan
