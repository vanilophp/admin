@extends('appshell::layouts.private')

@section('title')
    {{ __('Create Shipping Method') }}
@stop

@section('content')
    {!! Form::model($shippingMethod, ['route' => 'vanilo.admin.shipping-method.store', 'autocomplete' => 'off', 'class' => 'row']) !!}

    <div class="col-12 col-lg-8 col-xl-9">
    <x-appshell::card accent="success">
        <x-slot:title>{{ __('Shipping Method Details') }}</x-slot:title>

        @include('vanilo::shipping-method._form')

        <x-slot:footer>
            <x-appshell::create-button :text="__('Create shipping method')" />
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
