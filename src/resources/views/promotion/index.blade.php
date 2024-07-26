@extends('appshell::layouts.private')

@section('title')
    {{ __('Promotions') }}
@stop

@push('page-actions')
    <x-appshell::create-action model-name="promotion" route="vanilo.admin.promotion.create" />
@endpush

@section('content')
    <x-appshell::card accent="secondary">
        <x-slot:title>@yield('title')</x-slot:title>

{{--        {!! widget('vanilo::promotion.table')->render($promotions) !!}--}}
    </x-appshell::card>

{{--    @if($promotions->hasPages())--}}
{{--        <hr>--}}
{{--        <nav>--}}
{{--            {{ $promotions->withQueryString()->links() }}--}}
{{--        </nav>--}}
{{--    @endif--}}
@stop
