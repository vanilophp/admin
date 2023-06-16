@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing') }} {{ $shippingMethod->name }}
@stop

@section('content')
    {!! Form::model($shippingMethod, [
            'route'  => ['vanilo.admin.shipping-method.update', $shippingMethod],
            'method' => 'PUT'
        ])
    !!}

    <x-appshell::card accent="secondary">
        <x-slot:title>{{ __('Shipping Method Details') }}</x-slot:title>

        @include('vanilo::shipping-method._form')

        <x-slot:footer>
            <x-appshell::save-button />
            <x-appshell::cancel-button />
        </x-slot:footer>
    </x-appshell::card>

    {!! Form::close() !!}
@stop
