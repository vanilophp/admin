@extends('appshell::layouts.private')

@section('title')
    {{ __('Order :no', ['no' => $order->number]) }}
@stop

@push('page-actions')
    @include('vanilo::order.show._actions')
@endpush

@section('content')

    <div class="row mb-4">
        @include('vanilo::order.show._cards')
    </div>

    <div class="row mb-4">
        @include('vanilo::order.show._addresses')
        @include('vanilo::order.show._details')
    </div>

    <div class="row mb-4">

        <div class="col-12 col-md-8">
            @include('vanilo::order.show._items')
        </div>

        <div class="col-12 col-md-4">
            @include('vanilo::order.show._payment')
            @if(null !== $order->shipping_address_id)
                @include('vanilo::order.show._shipment')
            @endif
        </div>
    </div>

@stop
