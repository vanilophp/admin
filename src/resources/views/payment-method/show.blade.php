@extends('appshell::layouts.private')

@section('title')
    {{ $paymentMethod->getName() }}
@stop

@push('page-actions')
    <x-appshell::standard-actions :model="$paymentMethod" route="vanilo.admin.payment-method" :name="$paymentMethod->getName()" />
@endpush

@section('content')

    <x-appshell::card>
        <x-slot:title>{{ $paymentMethod->getName() }}</x-slot:title>
    </x-appshell::card>

@stop
