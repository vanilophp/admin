@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing') }} {{ $taxonomy->name }}
@stop

@section('content')
    <div class="row">

        <div class="col-12 col-md-6 col-lg-8 col-xl-9">
            {!! Form::model($taxonomy, [
                    'route'  => ['vanilo.admin.taxonomy.update', $taxonomy],
                    'method' => 'PUT'
                ])
            !!}

            <x-appshell::card accent="secondary">
                <x-slot:title>{{ __('Category Tree Data') }}</x-slot:title>

                @include('vanilo::taxonomy._form')

                <x-slot:footer>
                    <x-appshell::button variant="primary">{{ __('Save') }}</x-appshell::button>
                    <x-appshell::button variant="link" href="#" onclick="history.back();" class="text-secondary">{{ __('Cancel') }}</x-appshell::button>
                </x-slot:footer>
            </x-appshell::card>

            {!! Form::close() !!}
        </div>

        <div class="col-12 col-lg-4 col-xl-3">
            @include('vanilo::media._edit', ['model' => $taxonomy])
        </div>

    </div>
@stop
