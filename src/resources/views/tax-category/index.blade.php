@extends('appshell::layouts.private')

@section('title')
    {{ __('Tax Categories') }}
@stop


@push('page-actions')
    <x-appshell::create-action permission="create tax categories" route="vanilo.admin.tax-category.create" :button-text="__('New Tax Category')" />
@endpush

@section('content')

    <x-appshell::card accent="secondary">

        <x-slot:title>@yield('title')</x-slot:title>

        {!! widget('vanilo::tax-category.table')->render($taxCategories) !!}

    </x-appshell::card>

@stop
