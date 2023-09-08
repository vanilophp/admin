@extends('appshell::layouts.private')

@section('title')
    {{ $product->name }}
@stop

@push('page-actions')
    <x-appshell::standard-actions :model="$product" route="vanilo.admin.master_product" :name="$product->name" model-name="product" />
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-6 col-md-4 mb-3">
            <x-appshell::card-with-icon :icon="$product->is_active ? 'product' : 'product-off'" :type="$product->is_active ? 'success' : 'warning'">
                {{ $product->name }}
                @if (!$product->is_active)
                    <x-appshell::badge variant="light"><small>{{ __('inactive') }}</small></x-appshell::badge>
                @endif
                <x-slot:subtitle>
                    {{ $product->variants->implode('sku', ', ') }}&nbsp;
                    @if($multiChannelEnabled)
                        |
                        @if($product->channels->count())
                            {{ __('Channels') }}:
                            @can('view channels')
                                @foreach($product->channels->take(3) as $channel)
                                    <a href="{{ route('vanilo.admin.channel.show', $channel->id) }}">
                                        {{ $channel->name }}
                                    </a>
                                @endforeach
                            @else
                                {{ $product->channels->take(3)->implode('name', ' | ') }}
                            @endcan
                        @else
                            {{ __('no channels') }}
                        @endif

                        @if($product->channels->count() > 3)
                            | {{ __('+ :num more...', ['num' => $product->channels->count() - 3]) }}
                        @endif
                    @endif
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>

        <div class="col-sm-6 col-md-5 mb-3">
            <x-appshell::card-with-icon icon="time" type="info">
                {{ $product->state }}

                <x-slot:subtitle>
                    {{ __('Updated') }}
                    {{ show_datetime($product->updated_at) }}
                    |
                    {{ __('Created at') }}
                    {{ show_datetime($product->created_at) }}
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>

        <div class="col-sm-6 col-md-3 mb-3">
            <x-appshell::card-with-icon icon="bag">
                {{ $product->units_sold ?: '0' }}
                {{ __('units sold') }}
                <x-slot:subtitle>
                    @if ($product->last_sale_at)
                        {{ __('Last sale at') }}
                        {{ show_datetime($product->last_sale_at) }}
                    @else
                        {{ __('No sales were registered') }}
                    @endif
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>

        <div class="col-12 col-md-6 col-lg-8 col-xl-9 mb-3">
            @include('vanilo::master-product._variants')
            @include('vanilo::product._show_categories', ['for' => $product])
            @include('vanilo::product._show_properties', ['for' => $product])
        </div>

        <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-3">
            @include('vanilo::media._index', ['model' => $product])
        </div>
    </div>
@stop
