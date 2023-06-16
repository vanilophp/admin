@extends('appshell::layouts.private')

@section('title')
    {{ __('Create Shipping Method') }}
@stop

@section('content')
    {!! Form::model($shippingMethod, ['route' => 'vanilo.admin.shipping-method.store', 'autocomplete' => 'off']) !!}

    <x-appshell::card accent="success">
        <x-slot:title>{{ __('Shipping Method Details') }}</x-slot:title>

        @include('vanilo::shipping-method._form')

        <x-slot:footer>
            <x-appshell::create-button :text="__('Create shipping method')" />
            <x-appshell::cancel-button />
        </x-slot:footer>
    </x-appshell::card>

    {!! Form::close() !!}
@stop
