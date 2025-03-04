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
                <x-appshell::card-with-icon icon="globe" type="success">
                    {{ $country?->name ?? __('No country assigned') }}

                    <x-slot:subtitle>
                        {{ ($channel->currency ?? config('vanilo.foundation.currency.code')) }} | {{ ($channel->language ?? substr(app()->getLocale(), 0, 2)) }}
                    </x-slot:subtitle>
                </x-appshell::card-with-icon>
            </div>

        <div class="col">
            <x-appshell::card-with-icon icon="bag">
                {{ __(':num purchases', ['num' => $orderCount]) }}

                <x-slot:subtitle>
                    {{ show_date($lastOrderDate, __('No purchase recorded')) }}
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
