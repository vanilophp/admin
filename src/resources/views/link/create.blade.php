@extends('appshell::layouts.private')

@section('title')
    {{ __('Link a product to :name', ['name' => $sourceModel?->name ?? 'N/A']) }}
@stop

@section('content')
    @if($sourceModel)
    {!! Form::open(['url' => route('vanilo.admin.link.store'), 'autocomplete' => 'off', 'x-data' => 'vaniloSkuLookup']) !!}

    <x-appshell::card accent="success">

        <x-slot:title>{{ __('Link') }}</x-slot:title>

        <input type="hidden" name="source_id" value="{{ $sourceModel->id }}" />
        <input type="hidden" name="source_type" value="{{ shorten($sourceModel) }}" />

        @include('vanilo::link._form')

        <x-slot:footer>
            <x-appshell::create-button :text="__('Create link')" x-bind:disabled="!readyToSubmit()" />
            <x-appshell::cancel-button />
        </x-slot:footer>
    </x-appshell::card>

    {!! Form::close() !!}
    @else
        <x-appshell::alert>{{ __('The source product can not be found') }}</x-appshell::alert>
    @endif
@stop
