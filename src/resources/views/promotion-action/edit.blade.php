@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing') }} {{ $action->getTitle() }}
@stop

@section('content')
    <div class="row">
        <div class="col-12 col-lg-8 col-xl-9">
            {!! Form::model($action, [
                    'url'  => route('vanilo.admin.promotion.action.update', [$promotion, $action]),
                    'method' => 'PUT'
                ])
            !!}
                <x-appshell::card accent="secondary">
                    <x-slot:title>{{ __('Details') }}</x-slot:title>

                    @include('vanilo::promotion-action._form')

                    <x-slot:footer>
                        <x-appshell::save-button/>
                        <x-appshell::cancel-button/>
                    </x-slot:footer>
                </x-appshell::card>
            {!! Form::close() !!}
        </div>
    </div>
@stop
