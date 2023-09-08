@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing') }} {{ $product->name }}
@stop

@section('content')
<div class="row">

    <div class="col-12 col-lg-8 col-xl-9">
        {!! Form::model($product, [
                'route'  => ['vanilo.admin.product.update', $product],
                'method' => 'PUT'
            ])
        !!}
        <x-appshell::card accent="secondary">
            <x-slot:title>{{ __('Product Data') }}</x-slot:title>

            @include('vanilo::product._form')

            <x-slot:footer>
                <x-appshell::save-button />
                <x-appshell::cancel-button />
            </x-slot:footer>
        </x-appshell::card>
        {!! Form::close() !!}
    </div>

    <div class="col-12 col-lg-4 col-xl-3">
        @include('vanilo::media._edit', ['model' => $product])
        @if($multiChannelEnabled)
            @include('vanilo::channel._edit', ['model' => $product])
        @endif
    </div>

</div>
@stop
