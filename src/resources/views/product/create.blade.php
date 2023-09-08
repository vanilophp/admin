@extends('appshell::layouts.private')

@section('title')
    {{ __('Create new product') }}
@stop

@section('content')

    {!! Form::open(['route' => 'vanilo.admin.product.store', 'autocomplete' => 'off', 'enctype'=>'multipart/form-data', 'class' => 'row']) !!}

        <div class="col-12 col-lg-8 col-xl-9">
            <x-appshell::card accent="success">
                <x-slot:title>{{ __('Product Details') }}</x-slot:title>

                @include('vanilo::product._form')
                <x-slot:footer>
                    <x-appshell::create-button />
                    <x-appshell::cancel-button />
                </x-slot:footer>
            </x-appshell::card>
        </div>

        <div class="col-12 col-lg-4 col-xl-3">
            @include('vanilo::media._create')
            @include('vanilo::channel._create')
        </div>

    {!! Form::close() !!}

@stop
