@extends('appshell::layouts.private')

@section('title')
    {{ __('Shipping Methods') }}
@stop

@section('content')

    <div class="card card-accent-secondary">

        <div class="card-header">
            @yield('title')

            <div class="card-actionbar">
                @can('create shipping methods')
                    <a href="{{ route('vanilo.admin.shipping-method.create') }}"
                       class="btn btn-sm btn-outline-success float-right">
                        {!! icon('+') !!}
                        {{ __('New Shipping Method') }}
                    </a>
                @endcan
            </div>

        </div>

        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Zone') }}</th>
                    <th>{{ __('Calculation') }}</th>
                    <th>{{ __('Carrier') }}</th>
                    <th>{{ __('Enabled') }}</th>
                    <th style="width: 10%">&nbsp;</th>
                </tr>
                </thead>

                <tbody>
                @foreach($shippingMethods as $shippingMethod)
                    <tr>
                        <td>
                            <span class="font-lg mb-3 font-weight-bold">
                            @can('view shipping methods')
                                    <a href="{{ route('vanilo.admin.shipping-method.show', $shippingMethod) }}">{{ $shippingMethod->name }}</a>
                                @else
                                    {{ $shippingMethod->name }}
                                @endcan
                            </span>
                        </td>
                        <td>
                            @if($shippingMethod->zone_id)
                                @can('view zones')
                                    <a href="{{ route('vanilo.admin.zone.show', $shippingMethod->zone) }}" class="badge badge-pill badge-info">{{ $shippingMethod->zone->name }}</a>
                                @else
                                    <span class="badge badge-pill badge-info">{{ $shippingMethod->zone->name }}</span>
                                @endcan
                            @else
                                <span class="badge badge-pill badge-secondary">{{ __('Unrestricted') }}</span>
                            @endif
                        </td>
                        <td>
                            @if(null === $shippingMethod->calculator)
                                <span class="badge badge-pill badge-warning">{{ $shippingMethod->getCalculator()->getName() }}</span>
                            @else
                                <span class="badge badge-pill badge-primary">{{ $shippingMethod->getCalculator()->getName() }}</span>
                            @endif
                        </td>
                        <td>
                            @if(null === $shippingMethod->carrier)
                                {{ __('No carrier assigned') }}
                            @else
                                @can('view carriers')
                                    <a href="{{ route('vanilo.admin.carrier.show', $shippingMethod->getCarrier()) }}">
                                        {{ $shippingMethod->getCarrier()?->name() }}
                                    </a>
                                @else
                                    {{ $shippingMethod->getCarrier()->name() }}
                                @endcan
                            @endif
                        </td>
                        <td>
                            @if($shippingMethod->is_active)
                                {!! icon('active') !!}
                            @else
                                {!! icon('inactive') !!}
                            @endif
                        </td>
                        <td>
                            @can('edit shipping methods')
                                <a href="{{ route('vanilo.admin.shipping-method.edit', $shippingMethod) }}"
                                   class="btn btn-xs btn-outline-primary btn-show-on-tr-hover float-right">{{ __('Edit') }}</a>
                            @endcan

                            @can('delete shipping methods')
                                {{ Form::open([
                                    'url' => route('vanilo.admin.shipping-method.destroy', $shippingMethod),
                                    'data-confirmation-text' => __('Delete this shipping method: ":name"?', ['name' => $shippingMethod->name]),
                                    'method' => 'DELETE'
                                ])}}
                                <button
                                    class="btn btn-xs btn-outline-danger btn-show-on-tr-hover float-right">{{ __('Delete') }}</button>
                                {{ Form::close() }}
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>
    </div>

@stop
