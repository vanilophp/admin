@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing') }} {{ $shippingCategory->name }}
@stop

@section('content')

<div class="row mb-4">

    <div class="col-12 col-lg-8 col-xl-9 mb-4">
        {!! Form::model($shippingCategory, [
                'route'  => ['vanilo.admin.shipping-category.update', $shippingCategory],
                'method' => 'PUT'
            ])
        !!}

        <x-appshell::card accent="secondary">
            <x-slot:title>{{ __('Details') }}</x-slot:title>

            @include('vanilo::shipping-category._form')

            <x-slot:footer>
                <x-appshell::save-button />
                <x-appshell::cancel-button />
            </x-slot:footer>
        </x-appshell::card>

        {!! Form::close() !!}
    </div>
</div>

@stop
