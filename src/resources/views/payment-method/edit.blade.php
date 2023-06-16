@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing') }} {{ $paymentMethod->name }}
@stop

@section('content')
{!! Form::model($paymentMethod, [
        'route'  => ['vanilo.admin.payment-method.update', $paymentMethod],
        'method' => 'PUT'
    ])
!!}

    <x-appshell::card accent="secondary">
        <x-slot:title>{{ __('Payment Method Details') }}</x-slot:title>

        @include('vanilo::payment-method._form')

        <x-slot:footer>
            <x-appshell::save-button />
            <x-appshell::cancel-button />
        </x-slot:footer>
    </x-appshell::card>

{!! Form::close() !!}
@stop
