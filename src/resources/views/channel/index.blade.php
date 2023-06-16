@extends('appshell::layouts.private')

@section('title')
    {{ __('Channels') }}
@stop

@push('page-actions')
    @can('create channels')
        <x-appshell::button size="sm" variant="outline-success" icon="+" :href="route('vanilo.admin.channel.create')">
            {{ __('Create Channel') }}
        </x-appshell::button>
    @endcan
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
