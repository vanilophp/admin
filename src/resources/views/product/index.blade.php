@extends('appshell::layouts.private')

@section('title')
    {{ __('Products') }}
@stop

@push('page-actions')
    @can('create products')
        <div class="btn-group" role="group">
            <a href="{{ route('vanilo.admin.product.create') }}" class="btn btn-sm btn-outline-success">
                {!! icon('+') !!}
                {{ __('New Product') }}
            </a>
            <button type="button" class="btn btn-sm btn-outline-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"></button>
            <div class="dropdown-menu">
                <a href="{{ route('vanilo.admin.product.create') }}" class="dropdown-item">
                    {{ __('New Product') }}
                </a>
                <a href="{{ route('vanilo.admin.master_product.create') }}" class="dropdown-item">
                    {{ __('New Master Product') }}
                </a>
            </div>
        </div>
    @endcan
@endpush

@section('content')

    <x-appshell::card accent="secondary">
        <x-slot:title>@yield('title')</x-slot:title>
        <x-slot:actions>{!! $filters->render() !!}</x-slot:actions>

        {!! widget('vanilo::product.table')->render($products) !!}
    </x-appshell::card>

    @if($products->hasPages())
        <hr>
        <nav>
            {{ $products->withQueryString()->links() }}
        </nav>
    @endif
@stop
