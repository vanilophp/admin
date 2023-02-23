<div class="card mb-3">
    <div class="card-header">
        {{ __('Shipments') }}
    </div>

    <div class="card-body">
        <table class="table table-striped">
            <tbody>
            @forelse($order->shipments as $shipment)
                <tr>
                    <td>
                        <span class="font-lg mb-3 font-weight-bold" title="{{ $shipment->tracking_number ? __('Tracking number') : ($shipment->reference_number ? __('Reference number') : __('Local Shipment ID')) }}">
                            {{ $shipment->tracking_number ?? $shipment->reference_number ?? $shipment->id }}
                            <span class="badge badge-pill badge-secondary">{{ $shipment->getCarrier()->name() }}</span>
                        </span>
                        <div class="text-muted" title="{{ __('Last update') }}">
                            {{ show_datetime($shipment->updated_at) }}
                        </div>
                    </td>
                    <td>
                        <div>
                            <span class="badge badge-pill badge-primary">
                                {{ $shipment->status()->label() }}
                            </span>
                        </div>
                        <span class="font-italic">{{ $shipment->status_message }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td>{{ __('There are no shipments assigned to this order') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
