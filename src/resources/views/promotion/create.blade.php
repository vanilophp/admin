@extends('appshell::layouts.private')

@section('title')
    {{ __('Create Promotion') }}
@stop

@section('content')
    {!! Form::model($promotion, ['route' => 'vanilo.admin.promotion.store', 'autocomplete' => 'off']) !!}

    <x-appshell::card accent="success">
        <x-slot:title>{{ __('Details') }}</x-slot:title>

        @include('vanilo::promotion._form')

        <x-slot:footer>
            <x-appshell::create-button model-name="promotion"/>
            <x-appshell::cancel-button/>
        </x-slot:footer>

    </x-appshell::card>

    {!! Form::close() !!}
@stop
