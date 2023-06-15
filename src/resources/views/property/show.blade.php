@extends('appshell::layouts.private')

@section('title')
    {{ $property->name }} {{ __('property') }}
@stop

@section('content')
    <x-appshell::card accent="secondary">
        <x-slot:title>{{ __(':name Values', ['name' => $property->name]) }}</x-slot:title>

        @include('vanilo::property-value._index', ['propertyValues' => $property->values()])

        <x-slot:footer>
            @can('edit properties')
                <x-appshell::button :href="route('vanilo.admin.property.edit', $property)" variant="outline-primary">{{ __('Edit Property') }}</x-appshell::button>
            @endcan

            @can('delete properties')
                {!! Form::open([
                        'route' => ['vanilo.admin.property.destroy', $property],
                        'method' => 'DELETE',
                        'class' => 'd-inline',
                        'data-confirmation-text' => __('Delete this property: ":name"?', ['name' => $property->name])
                    ])
                !!}
                <x-appshell::button variant="outline-danger" type="submit">{{ __('Delete Property') }}</x-appshell::button>
                {!! Form::close() !!}
            @endcan
        </x-slot:footer>
    </x-appshell::card>
@stop
