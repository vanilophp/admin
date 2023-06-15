@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing') }} {{ $channel->name }}
@stop

@section('content')
{!! Form::model($channel, [
        'route'  => ['vanilo.admin.channel.update', $channel],
        'method' => 'PUT'
    ])
!!}

    <x-appshell::card accent="secondary">
        <x-slot:title>{{ __('Channel Details') }}</x-slot:title>

        @include('vanilo::channel._form')

        <x-slot:footer>
            <x-appshell::button variant="primary">{{ __('Save') }}</x-appshell::button>
            <x-appshell::button variant="link" href="#" onclick="history.back();" class="text-secondary">{{ __('Cancel') }}</x-appshell::button>
        </x-slot:footer>

    </x-appshell::card>

{!! Form::close() !!}
@stop
