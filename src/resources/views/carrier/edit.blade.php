@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing') }} {{ $carrier->name }}
@stop

@section('content')
{!! Form::model($carrier, [
        'route'  => ['vanilo.admin.carrier.update', $carrier],
        'method' => 'PUT'
    ])
!!}

    <div class="card card-accent-secondary">
        <div class="card-header">
            {{ __('Carrier Details') }}
        </div>

        <div class="card-body">
            @include('vanilo::carrier._form')
        </div>

        <div class="card-footer">
            <button class="btn btn-primary">{{ __('Save') }}</button>
            <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
        </div>
    </div>

{!! Form::close() !!}
@stop
