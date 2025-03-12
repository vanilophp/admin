@extends('appshell::layouts.private')

@section('title')
    {{ $video->title }}
@stop

@push('page-actions')
    @can('edit videos')
        <x-appshell::button variant="outline-secondary" :href="route('vanilo.admin.video.edit', $video)" size="sm">
            {{ __('Edit') }}
        </x-appshell::button>
    @endcan
@endpush

@section('content')

    <div class="row">
        <div class="col-sm-6 col-md-4 mb-3">
            <x-appshell::card-with-icon icon="file" :type="$video->is_published ? 'success' : 'warning'">
                {{ $video->title }}

                <x-slot:subtitle>
                    @if ($video->is_published)
                        {{ __('Published') }}
                    @else
                        {{ __('Unpublished') }}
                    @endif
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>
    </div>
@stop
