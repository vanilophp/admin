@extends('appshell::layouts.private')

@section('title')
    {{ __('Create Promotion Rule') }}
@stop

@section('content')

    {!! Form::model($rule, ['url' => route('vanilo.admin.promotion.rule.store', $promotion), 'autocomplete' => 'off', 'class' => 'row']) !!}

    <div class="col-12 col-lg-8 col-xl-9">
        <x-appshell::card accent="success">
            <x-slot:title>{{ __('Details') }}</x-slot:title>

            @include('vanilo::promotion-rule._form')

            <x-slot:footer>
                <x-appshell::create-button :text="__('Create Rule')"/>
                <x-appshell::cancel-button/>
            </x-slot:footer>
        </x-appshell::card>
    </div>

    {!! Form::close() !!}

@stop
