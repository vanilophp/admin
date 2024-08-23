@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing') }} {{ $rule->type }}
@stop

@section('content')
    <div class="row">
        <div class="col-12 col-lg-8 col-xl-9">
            {!! Form::model($rule, [
                    'url'  => route('vanilo.admin.promotion.rule.update', [$promotion, $rule]),
                    'method' => 'PUT'
                ])
            !!}
                <x-appshell::card accent="secondary">
                    <x-slot:title>{{ __('Details') }}</x-slot:title>

                    @include('vanilo::promotion-rule._form')

                    <x-slot:footer>
                        <x-appshell::save-button/>
                        <x-appshell::cancel-button/>
                    </x-slot:footer>
                </x-appshell::card>
            {!! Form::close() !!}
        </div>
    </div>
@stop
