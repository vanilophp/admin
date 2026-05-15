@extends('appshell::layouts.private')

@section('title')
    {{ $shippingMethod->name }}
@stop

@push('page-actions')
    <x-appshell::standard-actions :model="$shippingMethod" route="vanilo.admin.shipping-method" :name="$shippingMethod->name" />
@endpush

@section('content')

    <div class="row">
        <div class="col-sm-6 col-md-4 mb-3">
            <x-appshell::card-with-icon icon="carrier" :type="$shippingMethod->is_active ? 'success' : 'warning'">
                {{ $shippingMethod->getCarrier()?->getName() ?: 'N/A' }}
                @if (!$shippingMethod->is_active)
                    <x-appshell::badge variant="secondary" font-size="6">{{ __('inactive') }}</x-appshell::badge>
                @endif
                <x-slot:subtitle>
                    {{ $shippingMethod->getCalculator()->getName() }}
                    @if($shippingMethod->hasShippingCategory())
                        |
                        {{ $shippingMethod->getShippingCategory()?->getName() }}
                        ({{ $shippingMethod->getShippingCategoryMatchingCondition()?->label() }})
                    @endif
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>

        <div class="col-sm-6 col-md-4 mb-3">
            <x-appshell::card-with-icon icon="zone" type="info">
                {{ $shippingMethod->getZone()?->name ?: __('Geographically unrestricted') }}

                <x-slot:subtitle>
                    @if(isset($shippingMethod->eta_min) || isset($shippingMethod->eta_max))
                        {{ __('Eta') }}
                        {{ $shippingMethod->eta_min ?? '?' }}-{{ $shippingMethod->eta_max ?? '?' }}{{ $shippingMethod->eta_units }}
                    @else
                        {{ __('Updated') }}
                        {{ show_datetime($shippingMethod->updated_at) }}
                    @endif
                    @if(feature_is_enabled('multichannel'))
                        @include('vanilo::channel._list_for_card', ['model' => $shippingMethod])
                    @endif
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>

        <div class="col-sm-6 col-md-4 mb-3">
            <x-appshell::card-with-icon icon="bag">
                {{ $shippingMethod->usage_count ?: '0' }}
                {{ __('times used') }}
                <x-slot:subtitle>
                    @if ($shippingMethod->last_usage_at)
                        {{ __('Last used') }}
                        {{ show_datetime($shippingMethod->last_usage_at) }}
                    @else
                        {{ __('No usage was registered') }}
                    @endif
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>
    </div>

@stop
