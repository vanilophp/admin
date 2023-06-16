@extends('appshell::layouts.private')

@section('title')
    {{ __('Channels') }}
@stop

@push('page-actions')
    <x-appshell::create-action model-name="channel" route="vanilo.admin.channel.create" />
@endpush

@section('content')

    <x-appshell::card accent="secondary">
        <x-slot:title>@yield('title')</x-slot:title>

        {!! widget('vanilo::channel.table')->render($channels) !!}
    </x-appshell::card>

    @if($channels->hasPages())
        <hr>
        <nav>
            {{ $channels->withQueryString()->links() }}
        </nav>
    @endif

@stop
