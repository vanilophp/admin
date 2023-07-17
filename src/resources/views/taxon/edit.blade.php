@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing') }} {{ $taxon->name }}
@stop

@section('content')
<div class="row">
    <div class="col-12 col-lg-8 col-xl-9">
        {!! Form::model($taxon, ['url'  => route('vanilo.admin.taxon.update', [$taxonomy, $taxon]), 'method' => 'PUT']) !!}
        <x-appshell::card accent="secondary">
            <x-slot:title>{{ __(':category Data', ['category' => \Illuminate\Support\Str::singular($taxonomy->name)]) }}</x-slot:title>

            @include('vanilo::taxon._form')

            <x-slot:footer>
                <x-appshell::save-button />
                <x-appshell::cancel-button />
            </x-slot:footer>
        </x-appshell::card>
        {!! Form::close() !!}
    </div>

    <div class="col-12 col-lg-4 col-xl-3">
        @include('vanilo::media._edit', ['model' => $taxon])
    </div>
</div>
@stop
