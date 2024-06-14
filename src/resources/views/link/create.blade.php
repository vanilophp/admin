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
    {!! Form::open(['url' => route('vanilo.admin.link.store'), 'autocomplete' => 'off', 'x-data' => 'vaniloSkuLookup']) !!}

    <x-appshell::card accent="success">

        <x-slot:title>{{ __('Link') }}</x-slot:title>

        <x-vanilo::sku-lookup model-type-name="target_type" model-id-name="target_id" :sku-label="$desiredGroup ? __('Product to link') : __('Linked Product')"></x-vanilo::sku-lookup>

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
