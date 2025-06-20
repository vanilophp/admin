@extends('appshell::layouts.private')

@section('title')
    {{ __('Create Shipping Category') }}
@stop

@section('content')
{!! Form::model($shippingCategory, ['route' => 'vanilo.admin.shipping-category.store', 'autocomplete' => 'off']) !!}

    <x-appshell::card variant="success">

        <x-slot:title>{{ __('Details') }}</x-slot:title>

        @include('vanilo::shipping-category._form')

        <x-slot:footer>
            <x-appshell::create-button />
            <x-appshell::cancel-button />
        </x-slot:footer>
    </x-appshell::card>

{!! Form::close() !!}
@stop
