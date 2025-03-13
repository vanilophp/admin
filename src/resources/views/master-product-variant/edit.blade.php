@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing') }} {{ $variant->name }}
@stop

@push('page-actions')
    @can('delete products')
        {!! Form::open([
                'route' => ['vanilo.admin.master_product_variant.destroy', [$master, $variant]],
                'method' => 'DELETE',
                'class' => 'd-inline',
                'data-confirmation-text' => __('Delete this variant: ":name"?', ['name' => $variant->name])
            ])
        !!}
        <x-appshell::button variant="outline-danger" size="sm" icon="delete" :title="__('Delete This Variant')" />
        {!! Form::close() !!}
    @endcan
@endpush

@section('content')
<div class="row">

    <div class="col-12 col-lg-8 col-xl-9">
        {!! Form::model($variant, [
                'url'  => route('vanilo.admin.master_product_variant.update', [$master, $variant]),
                'method' => 'PUT'
            ])
        !!}
        <x-appshell::card accent="secondary">
            <x-slot:title>{{ __('Variant Data') }}</x-slot:title>

            @include('vanilo::master-product-variant._form')

            <x-slot:footer>
                <x-appshell::save-button />
                <x-appshell::cancel-button />
            </x-slot:footer>
        </x-appshell::card>
        {!! Form::close() !!}
    </div>

    <div class="col-12 col-lg-4 col-xl-3">
        @include('vanilo::media._edit', ['model' => $variant])
        @include('vanilo::video._edit', ['model' => $variant])

        @include('vanilo::product._show_properties', ['for' => $variant])
        @include('vanilo::link._index', ['model' => $variant])
    </div>

</div>
@stop

@push('onload-scripts')
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
@endpush()
