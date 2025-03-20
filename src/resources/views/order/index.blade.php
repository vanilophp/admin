@extends('appshell::layouts.private')

@section('title')
    {{ __('Orders') }}
@stop

@push('page-actions')
    <x-appshell::button variant="outline-success" :href="route('vanilo.admin.order.index',  array_merge(request()->query(), ['format' => 'csv']))" size="sm">
        {{ __('Export') }}
    </x-appshell::button>
@endpush

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
