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

            <x-appshell::card-with-icon icon="promotion" :type="vnl_admin_promo_status_color($promotion->getStatus())">
                {{ $promotion->name }}

                <x-slot:subtitle>
                    {{ $promotion->getStatus()->label() }}
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>

        <div class="col-sm-6 col-md-5 mb-3">
            <x-appshell::card-with-icon icon="time" type="info">
                {{ __('Duration') }}

                <x-slot:subtitle>
                    {{ vnl_promo_validity_text($promotion) }}
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>

        <div class="col-sm-6 col-md-3 mb-3">
            <x-appshell::card-with-icon icon="bag">
                {{ __('Used :num times', ['num' => $promotion->usage_count]) }}
                @if (null !== $promotion->usage_limit && 0 < $promotion->usage_count)
                    [{{round($promotion->usage_count/$promotion->usage_limit * 100)}}%]
                @endif

                <x-slot:subtitle>
                    @if (null === $promotion->usage_limit)
                        {{ __('The promotion can be used any number of times') }}
                    @else
                        {{ __('Limited to :num usages', ['num' => $promotion->usage_limit]) }}
                    @endif

                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <x-appshell::card>
                <x-slot:title>{{ __('Rules') }}</x-slot:title>

                <x-slot:actions>
                    <x-appshell::button :href="route('vanilo.admin.promotion.rule.create', $promotion)" variant="outline-success" icon="+" size="sm">{{ __('Add Rule') }}</x-appshell::button>
                </x-slot:actions>

                {!! widget('vanilo::promotion.rules')->render($promotion->getRules()) !!}

            </x-appshell::card>
        </div>

        <div class="col-md-6">
            <x-appshell::card>
                <x-slot:title>{{ __('Actions') }}</x-slot:title>

                <x-slot:actions>
                    <x-appshell::button :href="route('vanilo.admin.promotion.action.create', $promotion)" variant="outline-success" icon="+" size="sm">{{ __('Add Action') }}</x-appshell::button>
                </x-slot:actions>

                {!! widget('vanilo::promotion.actions')->render($promotion->getActions()) !!}

            </x-appshell::card>
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
