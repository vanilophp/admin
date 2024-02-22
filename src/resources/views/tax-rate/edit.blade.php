@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing') }} {{ $taxRate->name }}
@stop

@section('content')

    <div class="row mb-4">

        <div class="col col-xl-9">
            {!! Form::model($taxRate, [
                    'route'  => ['vanilo.admin.tax-rate.update', $taxRate],
                    'method' => 'PUT'
                ])
            !!}

            <x-appshell::card accent="secondary">
                <x-slot:title>{{ __('Details') }}</x-slot:title>

                @include('vanilo::tax-rate._form')

                <x-slot:footer>
                    <x-appshell::save-button/>
                    <x-appshell::cancel-button/>
                </x-slot:footer>
            </x-appshell::card>

            {!! Form::close() !!}
        </div>
    </div>

@stop
