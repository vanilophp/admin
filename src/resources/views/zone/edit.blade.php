@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing') }} {{ $zone->name }}
@stop

@section('content')
{!! Form::model($zone, [
        'route'  => ['vanilo.admin.zone.update', $zone],
        'method' => 'PUT'
    ])
!!}

    <x-appshell::card variant="secondary">

        <x-slot:title>{{ __('Zone Details') }}</x-slot:title>

        @include('vanilo::zone._form')

        <x-slot:footer>
            <x-appshell::save-button model-name="zone />
            <x-appshell::cancel-button />
        </x-slot:footer>
    </x-appshell::card>

{!! Form::close() !!}
@stop
