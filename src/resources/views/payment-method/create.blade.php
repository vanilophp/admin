@extends('appshell::layouts.private')

@section('title')
    {{ __('Create Payment Method') }}
@stop

@section('content')
{!! Form::model($paymentMethod, ['route' => 'vanilo.admin.payment-method.store', 'autocomplete' => 'off']) !!}

    <x-appshell::card accent="success">
        <x-slot:title>{{ __('Payment Method Details') }}</x-slot:title>

        @include('vanilo::payment-method._form')

        <x-slot:footer>
            <x-appshell::create-button :text="__('Create payment method')" />
            <x-appshell::cancel-button />
        </x-slot:footer>
    </x-appshell::card>

{!! Form::close() !!}
@stop
