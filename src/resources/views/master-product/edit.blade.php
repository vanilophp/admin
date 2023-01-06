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
        <div class="card card-accent-success">
            <div class="card-header">
                {{ __('Master Details') }}
            </div>
            <div class="card-body">
                @include('vanilo::master-product._form')
            </div>
            <div class="card-footer">
                <button class="btn btn-success">{{ __('Save') }}</button>
                <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <div class="col-12 col-lg-4 col-xl-3">
        @include('vanilo::media._edit', ['model' => $product])
    </div>

    {!! Form::close() !!}

@stop
