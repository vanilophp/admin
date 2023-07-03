@extends('appshell::layouts.private')

@section('title')
    {{ __('Create Carrier') }}
@stop

@section('content')
    {!! Form::model($carrier, ['route' => 'vanilo.admin.carrier.store', 'autocomplete' => 'off']) !!}

    <x-appshell::card accent="success">
        <x-slot:title>{{ __('Carrier Details') }}</x-slot:title>

        @include('vanilo::carrier._form')

        <x-slot:footer>
            <x-appshell::create-button model-name="carrier" />
            <x-appshell::cancel-button />
        </x-slot:footer>

    </x-appshell::card>

    {!! Form::close() !!}
@stop
