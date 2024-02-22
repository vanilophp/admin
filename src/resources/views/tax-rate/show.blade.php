@extends('appshell::layouts.private')

@section('title')
    {{ $taxRate->name }}
@stop

@push('page-actions')
    <x-appshell::standard-actions :model="$taxRate" route="vanilo.admin.tax-rate" :name="$taxRate->name" />
@endpush

@section('content')

    <x-appshell::card>
        <x-slot:title>{{ $taxRate->name }}</x-slot:title>
    </x-appshell::card>

@stop
