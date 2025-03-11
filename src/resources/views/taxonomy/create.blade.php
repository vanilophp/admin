@extends('appshell::layouts.private')

@section('title')
    {{ __('Create Category Tree') }}
@stop

@section('content')
{!! Form::open(['route' => 'vanilo.admin.taxonomy.store', 'autocomplete' => 'off','enctype'=>'multipart/form-data', 'class' => 'row']) !!}

    <div class="col-12 col-lg-8 col-xl-9 mb-4">
        <x-appshell::card accent="success">
            <x-slot:title>{{ __('Category Tree Details') }}</x-slot:title>

            @include('vanilo::taxonomy._form')

            <x-slot:footer>
                <x-appshell::create-button :text="__('Create category tree')" />
                <x-appshell::cancel-button />
            </x-slot:footer>
        </x-appshell::card>
    </div>

    <div class="col-12 col-lg-4 col-xl-3">
        @include('vanilo::media._create')
        @include('vanilo::video._create')
    </div>

{!! Form::close() !!}
@stop
