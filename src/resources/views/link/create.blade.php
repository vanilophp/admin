@extends('appshell::layouts.private')

@section('title')
    @if($desiredGroup)
        {{ __('Add Another Item as :name', ['name' => $desiredGroup->type->name]) }}
    @else
        {{ __('Link a Product to :name', ['name' => $sourceModel?->name ?? 'N/A']) }}
    @endif
@stop

@section('content')
    @if($sourceModel || $desiredGroup)
    {!! Form::open(['url' => route('vanilo.admin.link.store'), 'autocomplete' => 'off', 'x-data' => 'vaniloLookupController']) !!}

    <x-appshell::card accent="success">

        <x-slot:title>{{ __('Link') }}</x-slot:title>

        <div class="mb-3">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="lookup-sku" value="sku" x-model="lookupMode">
                <label class="form-check-label" for="lookup-sku">{{ __('by SKU') }}</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="lookup-name" value="name" x-model="lookupMode">
                <label class="form-check-label" for="lookup-name">{{ __('by Name') }}</label>
            </div>
        </div>

        <template x-if="lookupMode === 'sku'">
            <div x-data="vaniloSkuLookup">
                @include('vanilo::components.sku-lookup', [
                    'modelTypeName' => 'target_type',
                    'modelIdName' => 'target_id',
                    'skuLabel' => $desiredGroup ? __('Product to link') : __('Linked Product')
                ])
            </div>
        </template>

        <template x-if="lookupMode === 'name'">
            <div x-data="vaniloNameLookup">
                @include('vanilo::components.name-lookup', [
                    'modelTypeName' => 'target_type',
                    'modelIdName' => 'target_id',
                    'nameLabel' => $desiredGroup ? __('Product to link by name') : __('Linked Product by name')
                ])
            </div>
        </template>

        <hr>

        @if($desiredGroup)
            <input type="hidden" name="link_group_id" value="{{ $desiredGroup->id }}" />
            @include('vanilo::link._group', ['group' => $desiredGroup])
        @else
            <input type="hidden" name="source_id" value="{{ $sourceModel->id }}" />
            <input type="hidden" name="source_type" value="{{ shorten($sourceModel) }}" />
            @include('vanilo::link._form')
        @endif

        <x-slot:footer>
            @if($desiredGroup)
                <x-appshell::create-button :text="__('Link as :name', ['name' => $desiredGroup->type->name])" x-bind:disabled="!readyToSubmit()" />
            @else
            <x-appshell::create-button :text="__('Create link')" x-bind:disabled="!readyToSubmit()" />
            @endif
            <x-appshell::cancel-button />
        </x-slot:footer>
    </x-appshell::card>

    {!! Form::close() !!}
    @else
        <x-appshell::alert>{{ __('The source product or group can not be found') }}</x-appshell::alert>
    @endif
@stop

@push('scripts')
    <script>
        document.addEventListener('alpine:init', function() {
            Alpine.data('vaniloLookupController', () => ({
                lookupMode: 'sku' // default mode
            }));
        });
    </script>
@endpush
