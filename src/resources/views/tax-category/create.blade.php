@extends('appshell::layouts.private')

@section('title')
    {{ __('Create Tax Category') }}
@stop

@section('content')
{!! Form::model($taxCategory, ['route' => 'vanilo.admin.tax-category.store', 'autocomplete' => 'off']) !!}

    <x-appshell::card variant="success">

        <x-slot:title>{{ __('Details') }}</x-slot:title>

        @include('vanilo::tax-category._form')

        <x-slot:footer>
            <x-appshell::create-button />
            <x-appshell::cancel-button />
        </x-slot:footer>
    </x-appshell::card>

{!! Form::close() !!}
@stop
