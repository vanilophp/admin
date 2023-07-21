@extends('appshell::layouts.private')

@section('title')
    {{ __('New Translation') }}
@stop

@section('content')
    {!! Form::model($translation, ['route' => 'vanilo.admin.translation.store', 'autocomplete' => 'off']) !!}

    <x-appshell::card accent="success">
        <x-slot:title>{{ __('Translation of :title in :lang', ['lang' => $translation->language, 'title' => ($schema->getTitle)($translatable)]) }}</x-slot:title>

        @include('vanilo::translation._form')

        <x-slot:footer>
            <x-appshell::create-button model-name="translation" />
            <x-appshell::cancel-button />
        </x-slot:footer>

    </x-appshell::card>

    {!! Form::close() !!}
@stop
