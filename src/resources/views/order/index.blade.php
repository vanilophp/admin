@extends('appshell::layouts.private')

@section('title')
    {{ __('Orders') }}
@stop

@section('content')

    @component(theme_widget('group'), ['accent' => 'secondary'])
        @slot('title')@yield('title')@endslot

        @slot('actionbar')
            {!! $filters->render()  !!}
        @endslot

        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>{{ __('Number') }}</th>
                <th>{{ __('Ordered') }}</th>
                <th>{{ __('Ship To') }}</th>
                <th>{{ __('Payment Method') }}</th>
                <th>{{ __('Status') }}</th>
                <th style="width: 10%">&nbsp;</th>
            </tr>
            </thead>

            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>
                            <span class="font-lg mb-3 font-weight-bold">
                            @can('view orders')
                                    <a href="{{ route('vanilo.admin.order.show', $order) }}">{{ $order->number }}</a>
                                @else
                                    {{ $order->number }}
                                @endcan
                            </span>
                        <div class="text-muted">
                            {{ $order->billpayer->getName() }}
                        </div>
                    </td>
                    <td>
                            <span class="mb-3" title="{{ $order->created_at }}">
                                {{ show_datetime($order->created_at) }}
                            </span>
                        <div class="text-muted" title="{{ __('Order Total') }}">
                            {{ format_price($order->total()) }}
                        </div>
                    </td>
                    <td>
                            <?php $shippingAddress = $order->getShippingAddress(); ?>
                        @if($shippingAddress)
                            <span class="mb-3">
                                 {{ $shippingAddress->getCity() }}
                                </span>
                            <div class="text-muted">{{ $shippingAddress->country->name }}</div>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <div class="mt-2">
                                <span class="badge badge-pill badge-dark">
                                    {{ $order->currentPayment ? $order->currentPayment->method->name : __('n/a')  }}
                                </span>
                        </div>
                    </td>
                    <td>
                        <div class="mt-2">
                                <span class="badge badge-pill badge-{{$order->status->is_completed ? 'success' : ($order->status->is_cancelled ? 'warning': 'secondary')}}">
                                    {{ $order->status->label() }}
                                </span>
                        </div>
                    </td>
                    <td>
                        @can('delete orders')
                            {{ Form::open([
                                'url' => route('vanilo.admin.order.destroy', $order),
                                'data-confirmation-text' => __('Delete order from :name with number :number?', ['name' => $order->getBillpayer()->getName(), 'number' => $order->getNumber()]),
                                'method' => 'DELETE'
                            ])}}
                            <button class="btn btn-xs btn-outline-danger btn-show-on-tr-hover float-right">{{ __('Delete') }}</button>
                            {{ Form::close() }}
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>

    @endcomponent

    @if($orders->hasPages())
        <hr>
        <nav>
            {{ $orders->withQueryString()->links() }}
        </nav>
    @endif
@stop
