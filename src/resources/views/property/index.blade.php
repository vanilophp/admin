@extends('appshell::layouts.private')

@section('title')
    {{ __('Product Properties') }}
@stop

@push('page-actions')
    <x-appshell::create-action model-name="property" route="vanilo.admin.property.create" />
@endpush

@section('content')
    <x-appshell::card accent="secondary">
        <x-slot:title>@yield('title')</x-slot:title>

        {!! widget('vanilo::property.table')->render($properties) !!}
    </x-appshell::card>

    @if($properties->hasPages())
        <hr>
        <nav>
            {{ $properties->withQueryString()->links() }}
        </nav>
    @endif
@stop
