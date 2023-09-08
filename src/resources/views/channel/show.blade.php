@extends('appshell::layouts.private')

@section('title')
    {{ $channel->name }} {{ __('channel') }}
@stop

@push('page-actions')
    <x-appshell::standard-actions :model="$channel" route="vanilo.admin.channel" :name="$channel->name" />
@endpush

@section('content')
    <x-appshell::card>
        <x-slot:title>{{ __('Assigned Products') }}</x-slot:title>
        <x-slot:actions>
            <x-appshell::button href="#" variant="outline-success" icon="+" size="sm">{{ __('Assign a product') }}</x-appshell::button>
        </x-slot:actions>

        {!! widget('vanilo::channel.products')->render($channel->products) !!}

    </x-appshell::card>
@stop
