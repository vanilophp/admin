@extends('appshell::layouts.private')

@section('title')
    {{ __('Create Payment Method') }}
@stop

@section('content')
{!! Form::model($paymentMethod, ['route' => 'vanilo.admin.payment-method.store', 'autocomplete' => 'off', 'class' => 'row']) !!}

<div class="col-12 col-lg-8 col-xl-9">
    <x-appshell::card accent="success">
        <x-slot:title>{{ __('Payment Method Details') }}</x-slot:title>

        @include('vanilo::payment-method._form')

        <x-slot:footer>
            <x-appshell::create-button :text="__('Create payment method')" />
            <x-appshell::cancel-button />
        </x-slot:footer>
    </x-appshell::card>
</div>

<div class="col-12 col-lg-4 col-xl-3">
    @if($multiChannelEnabled)
        @include('vanilo::channel._create')
    @endif
</div>

{!! Form::close() !!}
@stop
