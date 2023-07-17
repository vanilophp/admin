@extends('appshell::layouts.private')

@section('title')
    {{ __('Create Property') }}
@stop

@section('content')
{!! Form::open(['route' => 'vanilo.admin.property.store', 'autocomplete' => 'off']) !!}

    <x-appshell::card accent="success">
        <x-slot:title>{{ __('Property Details') }}</x-slot:title>

        @include('vanilo::property._form')

        <x-slot:footer>
            <x-appshell::create-button model-name="property" />
            <x-appshell::cancel-button />
        </x-slot:footer>
    </x-appshell::card>

{!! Form::close() !!}
@stop
