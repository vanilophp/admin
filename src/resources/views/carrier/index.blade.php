@extends('appshell::layouts.private')

@section('title')
    {{ __('Carriers') }}
@stop

@push('page-actions')
    <x-appshell::create-action model-name="carrier" route="vanilo.admin.carrier.create" />
@endpush

@section('content')

    <x-appshell::card accent="secondary">
        <x-slot:title>@yield('title')</x-slot:title>

        {!! widget('vanilo::carrier.table')->render($carriers) !!}
    </x-appshell::card>

@stop
