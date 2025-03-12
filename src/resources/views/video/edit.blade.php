@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing') }} {{ $video->title }}
@stop

@section('content')
    {!!
        Form::model($video, [
            'route'  => ['vanilo.admin.video.update', $video],
            'method' => 'PUT'
        ])
    !!}

    <x-appshell::card accent="secondary">
        <x-slot:title>{{ __('Details') }}</x-slot:title>

        @include('vanilo::video._form')

        <x-slot:footer>
            <x-appshell::save-button/>
            <x-appshell::cancel-button/>
        </x-slot:footer>

    </x-appshell::card>

    {!! Form::close() !!}
@stop
