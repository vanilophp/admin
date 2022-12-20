@extends('appshell::layouts.private')

@section('title')
    {{ __('Create Product Variant') }}
@stop

@section('content')

    {!! Form::model($variant, ['url' => route('vanilo.admin.master-product-variant.store', $master), 'autocomplete' => 'off', 'enctype'=>'multipart/form-data', 'class' => 'row']) !!}

    <div class="col-12 col-lg-8 col-xl-9">
        <div class="card card-accent-success">
            <div class="card-header">
                {{ __('Variant Details') }}
            </div>
            <div class="card-body">
                @include('vanilo::master-product-variant._form')
            </div>
            <div class="card-footer">
                <button class="btn btn-success">{{ __('Create Product Variant') }}</button>
                <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4 col-xl-3">
        @include('vanilo::media._create')
    </div>

    {!! Form::close() !!}

@stop
