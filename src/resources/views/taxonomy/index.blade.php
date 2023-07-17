@extends('appshell::layouts.private')

@section('title')
    {{ __('Category Trees') }}
@stop

@push('page-actions')
    <x-appshell::create-action model-name="taxonomy" route="vanilo.admin.taxonomy.create" :button-text="__('New Category Tree')" />
@endpush

@section('content')
    <x-appshell::card accent="secondary">
        <x-slot:title>@yield('title')</x-slot:title>

        {!! widget('vanilo::taxonomy.table')->render($taxonomies) !!}
    </x-appshell::card>
@stop
