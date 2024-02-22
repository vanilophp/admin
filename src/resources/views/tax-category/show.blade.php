@extends('appshell::layouts.private')

@section('title')
    {{ $taxCategory->getName() }}
@stop

@push('page-actions')
    <x-appshell::standard-actions :model="$taxCategory" route="vanilo.admin.tax-category" :name="$taxCategory->getName()" />
@endpush

@section('content')

    <x-appshell::card>
        <x-slot:title>{{ __('Assigned rates to :category', ['category' => $taxCategory->getName()]) }}</x-slot:title>
        @forelse($taxRates as $taxRate)
            <x-appshell::badge>
                @can('edit tax rates')<a href="{{  route('vanilo.admin.tax-rate.edit', $taxRate)}}" style="color:inherit!important;">@endcan
                {{$taxRate->name}}
                @can('edit tax rates')</a>@endcan
            </x-appshell::badge>
        @empty
            <x-appshell::alert variant="info">
                {!! icon('info') !!}
                {{ __('There are no tax rates assigned to this tax category') }}
            </x-appshell::alert>
        @endforelse
    </x-appshell::card>

@stop
