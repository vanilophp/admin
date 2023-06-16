@extends('appshell::layouts.private')

@section('title')
    {{ __('Payment Methods') }}
@stop

@push('page-actions')
    <x-appshell::create-action permission="create payment methods" route="vanilo.admin.payment-method.create" :button-text="__('New Payment Method')" />
@endpush

@section('content')

    <x-appshell::card accent="secondary">

        <x-slot:title>@yield('title')</x-slot:title>

        {!! widget('vanilo::payment-method.table')->render($paymentMethods) !!}

    </x-appshell::card>

@stop
