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
            <x-appshell::button variant="success">{{ __('Create payment method') }}</x-appshell::button>
            <x-appshell::button variant="link" href="#" onclick="history.back();" class="text-secondary">{{ __('Cancel') }}</x-appshell::button>
        </x-slot:footer>
    </x-appshell::card>

{!! Form::close() !!}
@stop
