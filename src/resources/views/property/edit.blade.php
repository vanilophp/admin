@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing') }} {{ $property->name }}
@stop

@section('content')
{!! Form::model($property, [
        'route'  => ['vanilo.admin.property.update', $property],
        'method' => 'PUT'
    ])
!!}

    <x-appshell::card accent="secondary">
        <x-slot:title>{{ __('Property Details') }}</x-slot:title>

        @include('vanilo::property._form')

        <x-slot:footer>
            <x-appshell::button variant="success">{{ __('Save') }}</x-appshell::button>
            <x-appshell::button variant="link" href="#" onclick="history.back();" class="text-secondary">{{ __('Cancel') }}</x-appshell::button>
        </x-slot:footer>
    </x-appshell::card>

{!! Form::close() !!}
@stop
