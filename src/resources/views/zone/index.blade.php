@extends('appshell::layouts.private')

@section('title')
    {{ __('Geographic Zones') }}
@stop

@push('page-actions')
    <x-appshell::create-action model-name="zone" route="vanilo.admin.zone.create" />
@endpush

@section('content')

    <x-appshell::card accent="secondary">
        <x-slot:title>@yield('title')</x-slot:title>

        {!! widget('vanilo::zone.table')->render($zones) !!}
    </x-appshell::card>

@stop
