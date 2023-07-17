@extends('appshell::layouts.private')

@section('title')
    {{ __('Orders') }}
@stop

@section('content')

    <x-appshell::card accent="secondary">
        <x-slot:title>@yield('title')</x-slot:title>
        <x-slot:actions>{!! $filters->render()  !!}</x-slot:actions>

        {!! widget('vanilo::order.table')->render($orders) !!}

    </x-appshell::card>

    @if($orders->hasPages())
        <hr>
        <nav>
            {{ $orders->withQueryString()->links() }}
        </nav>
    @endif
@stop
