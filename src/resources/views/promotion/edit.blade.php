@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing') }} {{ $promotion->name }}
@stop

@section('content')
    {!!
        Form::model($promotion, [
            'route'  => ['vanilo.admin.promotion.update', $promotion],
            'method' => 'PUT'
        ])
    !!}

    <x-appshell::card accent="secondary">
        <x-slot:title>{{ __('Promotion Details') }}</x-slot:title>

        @include('vanilo::promotion._form')

        <x-slot:footer>
            <x-appshell::save-button/>
            <x-appshell::cancel-button/>
        </x-slot:footer>

    </x-appshell::card>

    {!! Form::close() !!}
@stop
