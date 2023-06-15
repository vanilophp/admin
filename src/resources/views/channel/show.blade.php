@extends('appshell::layouts.private')

@section('title')
    {{ $channel->name }} {{ __('channel') }}
@stop

@push('page-actions')

    @can('delete channels')
        {!! Form::open([
                'route' => ['vanilo.admin.channel.destroy', $channel],
                'method' => 'DELETE',
                'class' => 'd-inline',
                'data-confirmation-text' => __('Delete this channel: ":name"?', ['name' => $channel->name])
            ])
        !!}
        <x-appshell::button variant="outline-danger" type="submit" size="sm" icon="delete"
                            :title="__('Delete Channel')"></x-appshell::button>
        {!! Form::close() !!}
    @endcan

    @can('edit channels')
        <x-appshell::button :href="route('vanilo.admin.channel.edit', $channel)" size="sm"
            variant="light" icon="edit" :title="__('Edit Channel')">
        </x-appshell::button>
    @endcan

@endpush

@section('content')
@stop
