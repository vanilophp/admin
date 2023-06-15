@extends('appshell::layouts.private')

@section('title')
    {{ __('Create Channel') }}
@stop

@section('content')
{!! Form::model($channel, ['route' => 'vanilo.admin.channel.store', 'autocomplete' => 'off']) !!}

    <x-appshell::card accent="success">
        <x-slot:title>{{ __('Channel Details') }}</x-slot:title>

        @include('vanilo::channel._form')

        <x-slot:footer>
            <x-appshell::button variant="success">{{ __('Create channel') }}</x-appshell::button>
            <x-appshell::button variant="link" href="#" onclick="history.back();" class="text-secondary">{{ __('Cancel') }}</x-appshell::button>
        </x-slot:footer>

    </x-appshell::card>

{!! Form::close() !!}
@stop
