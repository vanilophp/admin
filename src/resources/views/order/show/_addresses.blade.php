<div class="col">
    <x-appshell::card class="h-100">
        <x-slot:title>{{ __('Bill To') }}</x-slot:title>

        <?php
        $billpayer = $order->billpayer;
        $billingAddress = $billpayer->getBillingAddress();
        ?>
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
    </x-appshell::card>
</div>

<div class="col">
    <x-appshell::card class="h-100">
        <x-slot:title>{{ __('Ship To') }}</x-slot:title>
        @if($order->shipping_method_id)
            <x-slot:actions>
                <a href="{{ route('vanilo.admin.shipping-method.show', $order->shippingMethod) }}" class="badge badge-pill bg-primary" title="{{ __('Shipping method') }}">
                    {{ $order->shippingMethod->name }}
                </a>
            </x-slot:actions>
        @endif

        <?php $shippingAddress = $order->getShippingAddress(); ?>
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
        </x-appshell::card>
</div>
