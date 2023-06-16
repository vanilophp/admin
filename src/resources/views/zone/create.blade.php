@extends('appshell::layouts.private')

@section('title')
    {{ __('Create Zone') }}
@stop

@section('content')
{!! Form::model($zone, ['route' => 'vanilo.admin.zone.store', 'autocomplete' => 'off']) !!}

    <x-appshell::card variant="success">

        <x-slot:title>{{ __('Zone Details') }}</x-slot:title>

        @include('vanilo::zone._form')

        <x-slot:footer>
            <x-appshell::create-button model-name="zone" />
            <x-appshell::cancel-button />
        </x-slot:footer>
    </x-appshell::card>

{!! Form::close() !!}
@stop
