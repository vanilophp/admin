@extends('appshell::layouts.private')

@section('title')
    {{ __('Create Tax Rate') }}
@stop

@section('content')
    {!! Form::model($taxRate, ['route' => 'vanilo.admin.tax-rate.store', 'autocomplete' => 'off', 'class' => 'row']) !!}

    <x-appshell::card variant="success" class="col col-xl-9">

        <x-slot:title>{{ __('Details') }}</x-slot:title>

        @include('vanilo::tax-rate._form')

        <x-slot:footer>
            <x-appshell::create-button/>
            <x-appshell::cancel-button/>
        </x-slot:footer>
    </x-appshell::card>

    {!! Form::close() !!}
@stop
