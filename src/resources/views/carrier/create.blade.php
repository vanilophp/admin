@extends('appshell::layouts.private')

@section('title')
    {{ __('Create Carrier') }}
@stop

@section('content')
{!! Form::model($carrier, ['route' => 'vanilo.admin.carrier.store', 'autocomplete' => 'off']) !!}

    <div class="card card-accent-success">

        <div class="card-header">
            {{ __('Carrier Details') }}
        </div>

        <div class="card-body">
            @include('vanilo::carrier._form')
        </div>

        <div class="card-footer">
            <button class="btn btn-success">{{ __('Create carrier') }}</button>
            <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
        </div>
    </div>

{!! Form::close() !!}
@stop
