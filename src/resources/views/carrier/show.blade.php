@extends('appshell::layouts.private')

@section('title')
    {{ $carrier->name }} {{ __('carrier') }}
@stop

@push('page-actions')
    <x-appshell::standard-actions :model="$carrier" route="vanilo.admin.carrier" :name="$carrier->name" />
@endpush

@section('content')
    <x-appshell::card>
        <x-slot:title>{{ __('Statistics') }}</x-slot:title>
    </x-appshell::card>
@stop
