@can('list videos')
<?php $videos = $model->videos ?>

<x-appshell::card accent="secondary">
    <x-slot:title>
        {{ __('Videos') }}
        <x-appshell::badge variant="secondary">{{ $videos?->count() ?? 0 }}</x-appshell::badge>
    </x-slot:title>

    @error('videos')
    <x-appshell::alert variant="danger">{{ $message }}</x-appshell::alert>
    @enderror
    @error('for')
    <x-appshell::alert variant="danger">{{ $message }}</x-appshell::alert>
    @enderror
    @error('forId')
    <x-appshell::alert variant="danger">{{ $message }}</x-appshell::alert>
    @enderror

    @if($videos?->isNotEmpty())
        @foreach($videos as $video)
            <div class="card mb-2">
                <div class="card-body p-0 d-flex align-items-center">
                <img class="mr-3 w-25 rounded-start object-fit-cover" style="max-height: 4.35rem;"
                     src="{{ $video->getThumbnail()->url ?? 'data:;base64,iVBORw0KGgoAAAANSUhEUgAAAPoAAAD6AQMAAACyIsh+AAAAA1BMVEWSj4+Y8UtxAAAAHklEQVRo3u3BAQEAAACCoP6vbojAAAAAAAAAAICwAyA6AAFG0xi/AAAAAElFTkSuQmCC' }}"
                     alt="{{ $video->getTitle() }}" title="{{ $video->getTitle() }}">
                <div class="w-50">
                    <div class="text-sm-left text-info fw-bold ps-2">
                        <span title="{{ $video->getVideoUrl() }}">{{ \Illuminate\Support\Str::limit($video->getTitle(), 25) }}</span>
                        &nbsp;
                        <a href="{{ $video->getVideoUrl() ?? '#' }}" target="_blank" title="{{ $video->getVideoUrl() ?? '?' }}" class="small text-secondary"
                           target="_blank">{!! icon('link') !!}</a>
                    </div>
                </div>
                <div class="w-25 pr-2 pl-0 b-l-1">
                    <div class="align-content-center text-center">
                        @can('delete videos')
                            {!! Form::open(['route' => ['vanilo.admin.video.destroy', $video], 'method' => 'DELETE', 'class' => "d-inline"]) !!}

                            <button class="btn btn-sm btn-outline-danger" title="{{ __('Delete video') }}">
                                {!! icon('delete') !!}
                            </button>

                            {!! Form::close() !!}
                        @endcan

                        @can('edit videos')
                            <button class="btn btn-sm btn-outline-secondary" title="{{ __('Edit video') }}" data-bs-toggle="modal" data-bs-target="#edit-video-modal-{{ $video->hash }}">
                                {!! icon('edit') !!}
                            </button>
                        @endcan
                    </div>
                </div>
            </div>
            </div>
            @include('vanilo::video._edit_modal')
        @endforeach
    @endif

    @can('create videos')
        <h6 class="mt-4">
            @if($videos?->isNotEmpty())
                {{ __('Add Further Videos') }}
            @else
                {{ __('Add a Video') }}
            @endif
        </h6>
        <x-appshell::button class="btn btn-sm btn-success" icon="+" title="{{ __('Add a video') }}"
                            data-bs-toggle="modal" data-bs-target="#create-video-modal"></x-appshell::button>
        @if ($errors->has('videos.*'))
            <x-appshell::alert variant="danger" class="my-2">
                @foreach($errors->get('videos.*') as $fileErrors)
                    @foreach($fileErrors as $error)
                        {{ $error }}<br>
                    @endforeach
                @endforeach
            </x-appshell::alert>
        @endif
    @endcan
</x-appshell::card>

@include('vanilo::video._create_modal')
@endcan
