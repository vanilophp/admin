<div class="card mb-3">
    <div class="card-header">
        {{ __('Bill To') }}
    </div>

    <?php
    $billpayer = $order->billpayer;
    $billingAddress = $billpayer->getBillingAddress();
    ?>
    <div class="card-body">
        <h6>{{ $billpayer->getName() }}</h6>
        @if( $billpayer->isOrganization())
            {{ $billpayer->getTaxNumber() }}<br>
            {{ $billpayer->registration_nr }}
        @endif
        <p>
            {{ $billpayer->email }}@if($billpayer->phone), {{ $billpayer->phone }} @endif<br>
            {{ $billingAddress->getAddress() }}<br>
            {{ $billingAddress->getCity() }}@if($billingAddress->getPostalCode()), {{ $billingAddress->getPostalCode() }} @endif<br>
            {{ $billingAddress->country->name }}<br>
        </p>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        {{ __('Ship To') }}
        @if($order->shipping_method_id)
            |
            <a href="{{ route('vanilo.admin.shipping-method.show', $order->shippingMethod) }}" class="badge badge-pill badge-primary" title="{{ __('Shipping method') }}">
                {{ $order->shippingMethod->name }}
            </a>
        @endif
    </div>

    <?php $shippingAddress = $order->getShippingAddress(); ?>
    <div class="card-body">
        @if($shippingAddress)
        <h6>{{ $shippingAddress->getName() }}</h6>
        <p>
            {{ $shippingAddress->getAddress() }}<br>
            {{ $shippingAddress->getCity() }}@if($shippingAddress->getPostalCode()), {{ $shippingAddress->getPostalCode() }} @endif<br>
            {{ $shippingAddress->country->name }}<br>
        </p>
        @else
        <h6>{{ __('No Shipping Address') }}</h6>
        @endif
    </div>
</div>
