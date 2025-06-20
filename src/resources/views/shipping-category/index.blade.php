@extends('appshell::layouts.private')

@section('title')
    {{ __('Shipping Categories') }}
@stop


@push('page-actions')
    <x-appshell::create-action permission="create shipping categories" route="vanilo.admin.shipping-category.create" :button-text="__('New Shipping Category')" />
@endpush

@section('content')

    <x-appshell::card accent="secondary">

        <x-slot:title>@yield('title')</x-slot:title>

        {!! widget('vanilo::shipping-category.table')->render($shippingCategories) !!}

    </x-appshell::card>

@stop
