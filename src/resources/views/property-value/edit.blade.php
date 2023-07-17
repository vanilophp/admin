@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing') }} {{ $propertyValue->title}}
@stop

@section('content')
{!! Form::model($propertyValue, ['url'  => route('vanilo.admin.property_value.update', [$property, $propertyValue]), 'method' => 'PUT', 'class' => 'row']) !!}

    <x-appshell::card accent="secondary">
        <x-slot:title>{{ __(':property Value', ['property' => $property->name]) }}</x-slot:title>

        @include('vanilo::property-value._form')

        <x-slot:footer>
            <x-appshell::save-button />
            <x-appshell::cancel-button />
        </x-slot:footer>
    </x-appshell::card>

{!! Form::close() !!}
@stop
