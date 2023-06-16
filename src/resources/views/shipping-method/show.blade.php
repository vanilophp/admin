@extends('appshell::layouts.private')

@section('title')
    {{ $shippingMethod->name }}
@stop

@push('page-actions')
    <x-appshell::standard-actions :model="$shippingMethod" route="vanilo.admin.shipping-method" :name="$shippingMethod->name" />
@endpush

@section('content')

    <x-appshell::card>
        <x-slot:title>{{ $shippingMethod->name }}</x-slot:title>
    </x-appshell::card>

@stop
