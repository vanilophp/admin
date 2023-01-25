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

    <div class="card card-accent-secondary">
        <div class="card-header">
            {{ __('Shipping Method Details') }}
        </div>

        <div class="card-body">
            @include('vanilo::shipping-method._form')
        </div>

        <div class="card-footer">
            <button class="btn btn-primary">{{ __('Save') }}</button>
            <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
        </div>
    </div>

    {!! Form::close() !!}
@stop
