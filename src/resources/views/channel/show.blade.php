@extends('appshell::layouts.private')

@section('title')
    {{ $channel->name }} {{ __('channel') }}
@stop

@push('page-actions')
    <x-appshell::standard-actions :model="$channel" route="vanilo.admin.channel" :name="$channel->name"/>
@endpush

@section('content')
    <div class="row mb-4">
        <div class="col">
            <x-appshell::card-with-icon icon="channel" type="info">
                {{ $channel->name }}
                <x-slot:subtitle>
                    {{ $channel->domain ? __('domain: :domain', ['domain' => $channel->domain]) : __('No domain assigned') }}
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>

            <div class="col">
                <x-appshell::card-with-icon icon="globe" :type="$country ? 'success' : null">
                    {{ $country?->name ?? __('No country assigned') }}

                    <x-slot:subtitle>
                        @if($channel->currency)
                            {{ __('Currency:') }}
                            {{ $channel->currency }}
                        @else
                            {{ __('Default currency (:value)', ['value' => config('vanilo.foundation.currency.code')]) }}
                        @endif
                        |
                        @if ($channel->language)
                            {{ __('Language:') }}
                            {{ $channel->language }}
                        @else
                            {{ __('Default language (:value)', ['value' => substr(app()->getLocale(), 0, 2)]) }}
                        @endif
                    </x-slot:subtitle>
                </x-appshell::card-with-icon>
            </div>

        <div class="col">
            <x-appshell::card-with-icon icon="bag">
                {{ __(':num purchases', ['num' => $orderCount]) }}

                <x-slot:subtitle>
                    @if($lastOrderDate)
                        {{ __('Last purchase:') }} {{ show_datetime($lastOrderDate) }}
                    @else
                        {{ __('No purchase recorded') }}
                    @endif
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>
    </div>

    <x-appshell::card>
        <x-slot:title>{{ __('Assigned Products') }}</x-slot:title>
        <x-slot:actions>
            <x-appshell::button href="#" variant="outline-success" icon="+" size="sm">{{ __('Assign a product') }}</x-appshell::button>
        </x-slot:actions>

        {!! widget('vanilo::channel.products')->render($products) !!}

    </x-appshell::card>
@stop
