@extends('appshell::layouts.private')

@section('title')
    {{ __('Add :property value', ['property' => $property->name]) }}
@stop

@section('content')
{!! Form::model($propertyValue, ['url' => route('vanilo.admin.property_value.store', $property), 'autocomplete' => 'off', 'class' => 'row']) !!}

    <x-appshell::card accent="success">
        <x-slot:title>{{ __('Value Details') }}</x-slot:title>

        @include('vanilo::property-value._form')

        <x-slot:footer>
            <x-appshell::button variant="success">{{ __('Create :property value', ['property' => $property->name]) }}</x-appshell::button>
            <x-appshell::cancel-button />
        </x-slot:footer>
    </x-appshell::card>

{!! Form::close() !!}
@stop
