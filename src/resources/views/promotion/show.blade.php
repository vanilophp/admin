@extends('appshell::layouts.private')

@section('title')
    {{ $promotion->name }}
@stop

@push('page-actions')
    <x-appshell::standard-actions :model="$promotion" route="vanilo.admin.promotion" :name="$promotion->name"/>
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-6 col-md-4 mb-3">
            @php
                $now = now();
                $hasStarted = $now->greaterThanOrEqualTo($promotion->starts_at);
                $hasEnded = $now->greaterThanOrEqualTo($promotion->ends_at);
            @endphp

            <x-appshell::card-with-icon icon="promotion" :type="!$hasStarted ? 'info' : ($hasStarted && !$hasEnded ? 'success' : 'secondary')">
                {{ $promotion->name }}

                <x-slot:subtitle>
                    @if (!$hasStarted)
                        {{ __('Not Started') }}
                    @elseif ($hasEnded)
                        {{ __('Ended') }}
                    @else
                        {{ __('Active') }}
                    @endif
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>

        <div class="col-sm-6 col-md-5 mb-3">
            <x-appshell::card-with-icon icon="time" type="info">
                {{ __('Duration') }}

                <x-slot:subtitle>
                    {{ __('Starts at') }}
                    {{ show_datetime($promotion->starts_at) }}
                    |
                    {{ __('Ends at') }}
                    {{ show_datetime($promotion->ends_at) }}
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>

        <div class="col-sm-6 col-md-3 mb-3">
            <x-appshell::card-with-icon icon="bag">
                {{ __('Used :num times', ['num' => $promotion->usage_count]) }}

                <x-slot:subtitle>
                    {{ __('Usage Limit: ') }} {{ $promotion->usage_limit ?? __('Unlimited') }}
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>
    </div>

    @if($promotion->is_coupon_based)
    @can('list coupons')
        <x-appshell::card>
            <x-slot:title>{{ __('Coupons') }}</x-slot:title>

            <x-slot:actions>
                <x-appshell::button :href="route('vanilo.admin.coupon.create', $promotion)" variant="outline-success" icon="+" size="sm">{{ __('Create a coupon') }}</x-appshell::button>
            </x-slot:actions>

            {!! widget('vanilo::coupon.table')->render($promotion->coupons) !!}

        </x-appshell::card>
    @endcan
    @endif
@stop
