@extends('appshell::layouts.private')

@section('title')
    {{ __('Create Channel') }}
@stop

@section('content')
{!! Form::model($channel, ['route' => 'vanilo.admin.channel.store', 'autocomplete' => 'off', 'class' => 'row']) !!}

    <x-appshell::card accent="success" class="col col col-md-8">
        <x-slot:title>{{ __('Channel Details') }}</x-slot:title>

        @include('vanilo::channel._form')

        <x-slot:footer>
            <x-appshell::create-button model-name="channel" />
            <x-appshell::cancel-button />
        </x-slot:footer>

    </x-appshell::card>

    <div class="col col-md-4">
        @foreach($sidebarWidgets ?? [] as $widget)
            @include($widget)
        @endforeach
    </div>

{!! Form::close() !!}
@stop
