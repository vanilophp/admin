@extends('appshell::layouts.private')

<?php $taxonTypeName =  \Illuminate\Support\Str::singular($taxonomy->name) ?>

@section('title')
    {{ __('Create :category', ['category' => $taxonTypeName]) }}
@stop

@section('content')
{!! Form::model($taxon, ['url' => route('vanilo.admin.taxon.store', $taxonomy), 'autocomplete' => 'off', 'enctype'=>'multipart/form-data', 'class' => 'row']) !!}
    <div class="col-12 col-lg-8 col-xl-9 mb-4">
        <x-appshell::card accent="success">
            <x-slot:title>{{ __(':category Details', ['category' => $taxonTypeName]) }}</x-slot:title>

            @include('vanilo::taxon._form')

            <x-slot:footer>
                <x-appshell::create-button :text="__('Create :category', ['category' => $taxonTypeName])" />
                <x-appshell::cancel-button />
            </x-slot:footer>
        </x-appshell::card>
    </div>

    <div class="col-12 col-lg-4 col-xl-3">
        @include('vanilo::media._create')
    </div>

{!! Form::close() !!}
@stop
