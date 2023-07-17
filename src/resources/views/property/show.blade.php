@extends('appshell::layouts.private')

@section('title')
    {{ $property->name }} {{ __('property') }}
@stop

@push('page-actions')
    <x-appshell::standard-actions :model="$property" route="vanilo.admin.property" :name="$property->name" />
@endpush

@section('content')
    <x-appshell::card accent="secondary">
        <x-slot:title>{{ __(':name Values', ['name' => $property->name]) }}</x-slot:title>

        @include('vanilo::property-value._index', ['propertyValues' => $property->values()])
    </x-appshell::card>
@stop
