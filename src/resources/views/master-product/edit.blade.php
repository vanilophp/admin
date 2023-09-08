@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing') }} {{ $product->name }}
@stop

@section('content')

<div class="row mb-4">

    <div class="col-12 col-lg-8 col-xl-9 mb-4">
        {!! Form::model($product, [
                'route'  => ['vanilo.admin.master_product.update', $product],
                'method' => 'PUT',
            ])
        !!}
        <x-appshell::card accent="secondary">
            <x-slot:title>{{ __('Master Details') }}</x-slot:title>

            @include('vanilo::master-product._form')

            <x-slot:footer>
                <x-appshell::save-button />
                <x-appshell::cancel-button />
            </x-slot:footer>
        </x-appshell::card>
        {!! Form::close() !!}
    </div>

    <div class="col-12 col-lg-4 col-xl-3">
        @include('vanilo::media._edit', ['model' => $product])
        @include('vanilo::channel._edit', ['model' => $product])
    </div>
</div>

@stop
