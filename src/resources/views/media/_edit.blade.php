<?php $media = $model->getMedia($collection ?? 'default') ?>

<x-appshell::card accent="secondary">
    <x-slot:title>
        {{ __('Images') }}
        <x-appshell::badge variant="secondary">{{ $media->count() }}</x-appshell::badge>
    </x-slot:title>

    @error('images')
    <x-appshell::alert variant="danger">{{ $message }}</x-appshell::alert>
    @enderror
    @error('for')
    <x-appshell::alert variant="danger">{{ $message }}</x-appshell::alert>
    @enderror
    @error('forId')
    <x-appshell::alert variant="danger">{{ $message }}</x-appshell::alert>
    @enderror
    @foreach($media as $medium)
        <div class="card mb-2">
            <div class="card-body p-0 d-flex align-items-center">
                <img class="mr-3 w-25 rounded-start object-fit-cover" style="max-height: 4.35rem;" src="{{ $medium->getUrl('thumbnail') }}"
                     alt="{{ $medium->name }}" title="{{ $medium->name }}">
                <div class="w-50">
                    <div class="text-sm-left text-info fw-bold ps-2">
                        <span title="{{ $medium->getPath() }}">{{ $medium->human_readable_size }}</span>
                        &nbsp;
                        <a href="{{ $medium->getUrl() }}" title="{{ $medium->getUrl() }}" class="small text-secondary"
                           target="_blank">{!! icon('link') !!}</a>
                    </div>
                </div>
                <div class="w-25 pr-2 pl-0 b-l-1">
                    <div class="align-content-center text-center">
                        @can('delete media')
                            {!! Form::open(['route' => ['vanilo.admin.media.destroy', $medium], 'method' => 'DELETE', 'class' => "d-inline"]) !!}
                            <button class="btn btn-sm btn-outline-danger" title="{{ __('Delete image') }}">
                                {!! icon('delete') !!}
                            </button>
                            {!! Form::close() !!}
                        @endcan

                        @can('edit media')
                            @unless($medium->getCustomProperty('isPrimary'))
                                {!! Form::open(['route' => ['vanilo.admin.media.update', $medium], 'method' => 'PUT', 'class' => "d-inline"]) !!}
                                <button class="btn btn-sm btn-outline-secondary mr-1" title="{{ __('Set as Primary Image') }}">
                                    {!! icon('check') !!}
                                </button>
                                {!! Form::close() !!}
                            @else
                                <button class="btn btn-sm btn-info mr-1" title="{{ __('This is the primary image') }}" onclick="alert('{{ __("This is already the primary image")  }}')">
                                    {!! icon('check') !!}
                                </button>
                            @endunless
                        @endcan
                    </div>
                </div>

            </div>

        </div>
    @endforeach

    @can('create media')
        <h6 class="mt-4">
            @if($media->isNotEmpty())
                {{ __('Add Further Images') }}
            @else
                {{ __('Add Images') }}
            @endif
        </h6>

        <form action="{{ route('vanilo.admin.media.store') }}" enctype="multipart/form-data" method="post" class="input-group mb-4">
            {{ Form::file('images[]', ['multiple', 'class' => 'form-control']) }}
            @csrf
            {{ Form::hidden('for', shorten(get_class($model))) }}
            {{ Form::hidden('forId', $model->id) }}

            <x-appshell::button class="btn btn-sm btn-success" icon="upload" title="{{ __('Upload image(s)') }}">
            </x-appshell::button>
        </form>
        @if ($errors->has('images.*'))
            <x-appshell::alert variant="danger" class="my-2">
                @foreach($errors->get('images.*') as $fileErrors)
                    @foreach($fileErrors as $error)
                        {{ $error }}<br>
                    @endforeach
                @endforeach
            </x-appshell::alert>
        @endif
    @endcan
</x-appshell::card>
