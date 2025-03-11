@extends('appshell::layouts.private')

@section('title')
    {{ __('Create Master Product') }}
@stop

@section('content')

    {!! Form::open(['route' => 'vanilo.admin.master_product.store', 'autocomplete' => 'off', 'files' => true, 'class' => 'row']) !!}

    <div class="col-12 col-lg-8 col-xl-9">
        <x-appshell::card accent="success">
            <x-slot:title>{{ __('Master Details') }}</x-slot:title>

            @include('vanilo::master-product._form')
            <x-slot:footer>
                <x-appshell::create-button :text="__('Create Master Product')" />
                <x-appshell::cancel-button />
            </x-slot:footer>
        </x-appshell::card>
    </div>

    <div class="col-12 col-lg-4 col-xl-3">
        @include('vanilo::media._create')
        @include('vanilo::video._create')
        @if($multiChannelEnabled)
            @include('vanilo::channel._create')
        @endif
    </div>

    {!! Form::close() !!}

@stop
