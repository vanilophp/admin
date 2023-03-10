@extends('appshell::layouts.private')

@section('title')
    {{ $zone->name }} {{ __(':scope Zone', ['scope' => $zone->scope->label()]) }}
@stop

@section('content')

    <div class="card mb-4">
        <div class="card-body">
            @foreach($zone->members as $member)
                <span @class(['badge badge-pill', 'badge-info' => $member->isCountry(), 'badge-success' => $member->isProvince()])>
                    {{ $member->member->name }}
                </span>
            @endforeach

            @can('create zones')
                <a href="{{ route('vanilo.admin.zone.create') }}"
                   class="btn btn-success btn-sm mb-1"
                   title="{{ __('Add member') }}">{!! icon('+') !!}</a>
            @endcan

        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @can('edit zones')
                <a href="{{ route('vanilo.admin.zone.edit', $zone) }}" class="btn btn-outline-primary">{{ __('Edit Zone') }}</a>
            @endcan

            @can('delete carriers')
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
