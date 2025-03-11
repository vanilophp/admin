@extends('appshell::layouts.private')

@section('title')
    {{ __('Create Product Variant') }}
@stop

@section('content')

    {!! Form::model($variant, ['url' => route('vanilo.admin.master_product_variant.store', $master), 'autocomplete' => 'off', 'enctype'=>'multipart/form-data', 'class' => 'row']) !!}

    <div class="col-12 col-lg-8 col-xl-9">
        <x-appshell::card accent="success">
            <x-slot:title>{{ __('Variant Details') }}</x-slot:title>

            @include('vanilo::master-product-variant._form')

            <x-slot:footer>
                <x-appshell::create-button :text="__('Create Product Variant')" />
                <x-appshell::cancel-button />
            </x-slot:footer>
        </x-appshell::card>
    </div>

    <div class="col-12 col-lg-4 col-xl-3">
        @include('vanilo::media._create')
        @include('vanilo::video._create')
    </div>

    {!! Form::close() !!}

@stop

@push('onload-scripts')
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
@endpush()
