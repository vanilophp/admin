@extends('appshell::layouts.private')

@section('title')
    {{ $zone->name }} {{ __(':scope Zone', ['scope' => $zone->scope->label()]) }}
@stop

@push('page-actions')
    <x-appshell::standard-actions :model="$zone" route="vanilo.admin.zone" :name="$zone->name" />
@endpush

@section('content')

    <x-appshell::card>
        <x-slot:title>{{ __('Zone members') }}</x-slot:title>
        @include('vanilo::zone-member._index', ['zoneMembers' => $zone->members])
    </x-appshell::card>

@stop
