@extends('appshell::layouts.private')

@section('title')
    {{ $shippingMethod->name }}
@stop

@section('content')

    <div class="card mb-3">
        <div class="card-header">
            <h5>{{ $shippingMethod->name }}</h5>
        </div>
        <div class="card-body">

        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @can('edit payment methods')
                <a href="{{ route('vanilo.admin.shipping-method.edit', $shippingMethod) }}"
                   class="btn btn-outline-primary">{{ __('Edit Shipping Method') }}</a>
            @endcan

            @can('delete shipping methods')
                {!! Form::open([
                        'route' => ['vanilo.admin.shipping-method.destroy', $shippingMethod],
                        'method' => 'DELETE',
                        'class' => 'float-right',
                        'data-confirmation-text' => __('Delete this shipping method: ":name"?', ['name' => $shippingMethod->name])
                    ])
                !!}
                <button class="btn btn-outline-danger">
                    {{ __('Delete Shipping Method') }}
                </button>
                {!! Form::close() !!}
            @endcan
        </div>
    </div>

@stop
