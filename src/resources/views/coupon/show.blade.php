@extends('appshell::layouts.private')

@section('title')
    {{ $coupon->code }}
@stop

@push('page-actions')
    <x-appshell::standard-actions :model="$coupon" :edit-url="route('vanilo.admin.coupon.edit', [$promotion, $coupon])" :delete-url="route('vanilo.admin.coupon.destroy', [$promotion, $coupon])" :name="$coupon->code"/>
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-6 col-md-4 mb-3">
            @php
                $hasExpired = now()->greaterThanOrEqualTo($coupon->expires_at);
            @endphp

            <x-appshell::card-with-icon icon="coupon" :type="$hasExpired ? 'secondary' : 'success'">
                {{ $coupon->code }}

                <x-slot:subtitle>
                    {{ $hasExpired ? __('Expired') : __('Active') }}
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>

        <div class="col-sm-6 col-md-5 mb-3">
            <x-appshell::card-with-icon icon="time" type="info">
                {{ __('Expires at') }}

                <x-slot:subtitle>
                    {{ show_datetime($coupon->expires_at) }}
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>

        <div class="col-sm-6 col-md-3 mb-3">
            <x-appshell::card-with-icon icon="bag">
                {{ __('Used :num times', ['num' => $coupon->usage_count]) }}

                <x-slot:subtitle>
                    {{ __('Usage Limit: ') }} {{ $coupon->usage_limit ?? __('Unlimited') }} |
                    {{ __('Per Customer Usage Limit: ') }} {{ $coupon->per_customer_usage_limit ?? __('Unlimited') }}
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>
    </div>
@stop

