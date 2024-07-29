@extends('appshell::layouts.private')

@section('title')
    {{ $promotion->name }}
@stop

@push('page-actions')
    <x-appshell::standard-actions :model="$promotion" route="vanilo.admin.promotion" :name="$promotion->name"/>
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-6 col-md-4 mb-3">
            @php
                $now = now();
                $hasStarted = $now->greaterThanOrEqualTo($promotion->starts_at);
                $hasEnded = $now->greaterThanOrEqualTo($promotion->ends_at);
            @endphp

            <x-appshell::card-with-icon :icon="$hasStarted && !$hasEnded ? 'promotion' : 'promotion-off'" :type="!$hasStarted ? 'info' : ($hasStarted && !$hasEnded ? 'success' : 'warning')">
                {{ $promotion->name }}

                <x-slot:subtitle>
                    @if (!$hasStarted)
                        {{ __('Not Started') }}
                    @elseif ($hasEnded)
                        {{ __('Ended') }}
                    @else
                        {{ __('Active') }}
                    @endif
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>

        <div class="col-sm-6 col-md-5 mb-3">
            <x-appshell::card-with-icon icon="time" type="info">
                {{ __('Promotion Duration') }}

                <x-slot:subtitle>
                    {{ __('Starts at') }}
                    {{ show_datetime($promotion->starts_at) }}
                    |
                    {{ __('Ends at') }}
                    {{ show_datetime($promotion->ends_at) }}
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>

        <div class="col-sm-6 col-md-3 mb-3">
            <x-appshell::card-with-icon icon="bag">
                {{ __('Usage Count: ') }} {{ $promotion->usage_count }}

                <x-slot:subtitle>
                    {{ __('Usage Limit: ') }} {{ $promotion->usage_limit ?? __('Unlimited') }}
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>
    </div>
@stop
