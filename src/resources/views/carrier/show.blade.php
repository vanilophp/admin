@extends('appshell::layouts.private')

@section('title')
    {{ $carrier->name }} {{ __('carrier') }}
@stop

@section('content')

    <div class="card">
        <div class="card-body">
            @can('edit carriers')
                <a href="{{ route('vanilo.admin.carrier.edit', $carrier) }}" class="btn btn-outline-primary">{{ __('Edit Carrier') }}</a>
            @endcan

            @can('delete carriers')
                {!! Form::open([
                        'route' => ['vanilo.admin.carrier.destroy', $carrier],
                        'method' => 'DELETE',
                        'class' => 'float-right',
                        'data-confirmation-text' => __('Delete this carrier: ":name"?', ['name' => $carrier->name])
                    ])
                !!}
                <button class="btn btn-outline-danger">
                    {{ __('Delete Carrier') }}
                </button>
                {!! Form::close() !!}
            @endcan
        </div>
    </div>

@stop
