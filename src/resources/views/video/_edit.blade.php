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
                <div class="card-body p-4 d-flex align-items-center justify-content-between" style="height: 3.35rem;">
                    <div>
                        <div class="text-sm-left text-info fw-bold ps-2">
                            <span title="{{ $video->title }}">{{ $video->title }}</span>
                        </div>
                    </div>
                    <div>
                        <div>
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

                                @include('vanilo::video._edit_modal')
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    @can('create videos')
        <x-appshell::button class="btn btn-sm btn-success" icon="upload" title="{{ __('Upload video(s)') }}" data-bs-toggle="modal" data-bs-target="#create-video-modal">
            @if($videos?->isNotEmpty())
                {{ __('Add Another Video') }}
            @else
                {{ __('Add Videos') }}
            @endif
        </x-appshell::button>
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
