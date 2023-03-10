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

    <div class="card card-accent-success">

        <div class="card-header">
            {{ __('Zone Details') }}
        </div>

        <div class="card-body">
            @include('vanilo::zone._form')
        </div>

        <div class="card-footer">
            <button class="btn btn-primary">{{ __('Save') }}</button>
            <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
        </div>
    </div>

{!! Form::close() !!}
@stop
