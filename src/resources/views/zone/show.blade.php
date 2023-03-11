@extends('appshell::layouts.private')

@section('title')
    {{ $zone->name }} {{ __(':scope Zone', ['scope' => $zone->scope->label()]) }}
@stop

@section('content')

    <div class="card mb-4">
        <div class="card-body">
            @include('vanilo::zone-member._index', ['zoneMembers' => $zone->members])
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @can('edit zones')
                <a href="{{ route('vanilo.admin.zone.edit', $zone) }}" class="btn btn-outline-primary">{{ __('Edit Zone') }}</a>
            @endcan

            @can('delete zones')
                {!! Form::open([
                        'route' => ['vanilo.admin.zone.destroy', $zone],
                        'method' => 'DELETE',
                        'class' => 'float-right',
                        'data-confirmation-text' => __('Delete this zone: ":name"?', ['name' => $zone->name])
                    ])
                !!}
                <button class="btn btn-outline-danger">
                    {{ __('Delete zone') }}
                </button>
                {!! Form::close() !!}
            @endcan
        </div>
    </div>

@stop
