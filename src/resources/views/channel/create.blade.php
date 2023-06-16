@extends('appshell::layouts.private')

@section('title')
    {{ __('Create Channel') }}
@stop

@section('content')
{!! Form::model($channel, ['route' => 'vanilo.admin.channel.store', 'autocomplete' => 'off']) !!}

    <x-appshell::card accent="success">
        <x-slot:title>{{ __('Channel Details') }}</x-slot:title>

        @include('vanilo::channel._form')

        <x-slot:footer>
            <x-appshell::create-button model-name="channel" />
            <x-appshell::cancel-button />
        </x-slot:footer>

    </x-appshell::card>

{!! Form::close() !!}
@stop
