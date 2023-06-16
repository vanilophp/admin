@extends('appshell::layouts.private')

@section('title')
    {{ __('Shipping Methods') }}
@stop


@push('page-actions')
    <x-appshell::create-action permission="create shipping methods" route="vanilo.admin.shipping-method.create" :button-text="__('New Shipping Method')" />
@endpush

@section('content')

    <x-appshell::card accent="secondary">

        <x-slot:title>@yield('title')</x-slot:title>

        {!! widget('vanilo::shipping-method.table')->render($shippingMethods) !!}

    </x-appshell::card>

@stop
