@extends('appshell::layouts.private')

@section('title')
    {{ __('Create Shipping Method') }}
@stop

@section('content')
    {!! Form::model($shippingMethod, ['route' => 'vanilo.admin.shipping-method.store', 'autocomplete' => 'off']) !!}

    <div class="card card-accent-success">

        <div class="card-header">
            {{ __('Shipping Method Details') }}
        </div>

        <div class="card-body">
            @include('vanilo::shipping-method._form')
        </div>

        <div class="card-footer">
            <button class="btn btn-success">{{ __('Create shipping method') }}</button>
            <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
        </div>
    </div>

    {!! Form::close() !!}
@stop
