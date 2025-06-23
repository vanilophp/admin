@extends('appshell::layouts.private')

@section('title')
    {{ $shippingCategory->getName() }}
@stop

@push('page-actions')
    <x-appshell::standard-actions :model="$shippingCategory" route="vanilo.admin.shipping-category" :name="$shippingCategory->getName()" />
@endpush