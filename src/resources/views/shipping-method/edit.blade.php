@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing') }} {{ $shippingMethod->name }}
@stop

@section('content')
<div class="row mb-4">

    <div class="col-12 col-lg-8 col-xl-9 mb-4">
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
    </div>

    <div class="col-12 col-lg-4 col-xl-3">
        @if($multiChannelEnabled)
            @include('vanilo::channel._edit', ['model' => $shippingMethod])
        @endif
    </div>
</div>
@stop
