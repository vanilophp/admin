@extends('appshell::layouts.private')

@section('title')
    {{ __('Tax Rates') }}
@stop


@push('page-actions')
    <x-appshell::create-action permission="create tax rates" route="vanilo.admin.tax-rate.create" :button-text="__('New Tax Rate')" />
@endpush

@section('content')

    <x-appshell::card accent="secondary">

        <x-slot:title>@yield('title')</x-slot:title>

        {!! widget('vanilo::tax-rate.table')->render($taxRates) !!}

    </x-appshell::card>

@stop
