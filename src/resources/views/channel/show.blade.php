@extends('appshell::layouts.private')

@section('title')
    {{ $channel->name }} {{ __('channel') }}
@stop

@push('page-actions')
    <x-appshell::standard-actions :model="$channel" route="vanilo.admin.channel" :name="$channel->name" />
@endpush

@section('content')
    <x-appshell::card>
        <x-slot:title>{{ __('Statistics') }}</x-slot:title>
    </x-appshell::card>
@stop
