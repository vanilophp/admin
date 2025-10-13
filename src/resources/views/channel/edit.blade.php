@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing') }} {{ $channel->name }}
@stop

@section('content')
{!! Form::model($channel, [
        'route'  => ['vanilo.admin.channel.update', $channel],
        'method' => 'PUT'
    ])
!!}
<div class="row">
    <div class="col col-md-8">
    <x-appshell::card accent="secondary">
        <x-slot:title>{{ __('Channel Details') }}</x-slot:title>

        @include('vanilo::channel._form')

        <x-slot:footer>
            <x-appshell::save-button />
            <x-appshell::cancel-button />
        </x-slot:footer>

    </x-appshell::card>
    </div>

    <div class="col col-md-4">
        @foreach($sidebarWidgets ?? [] as $widget)
            @include($widget)
        @endforeach
    </div>
</div>
{!! Form::close() !!}
@stop
