@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing') }} {{ $carrier->name }}
@stop

@section('content')
    {!! Form::model($carrier, [
            'route'  => ['vanilo.admin.carrier.update', $carrier],
            'method' => 'PUT'
        ])
    !!}

    <x-appshell::card accent="secondary">
        <x-slot:title>{{ __('Carrier Details') }}</x-slot:title>

        @include('vanilo::carrier._form')

        <x-slot:footer>
            <x-appshell::save-button />
            <x-appshell::cancel-button />
        </x-slot:footer>

    </x-appshell::card>

    {!! Form::close() !!}
@stop
