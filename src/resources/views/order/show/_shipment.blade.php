<x-appshell::card>
    <x-slot:title>{{ __('Shipments') }}</x-slot:title>

    <table class="table table-striped">
        <tbody>
        @forelse($order->shipments as $shipment)
            <tr>
                <td>
                    <span class="mb-3 fw-bold"
                          title="{{ $shipment->tracking_number ? __('Tracking number') : ($shipment->reference_number ? __('Reference number') : __('Local Shipment ID')) }}">
                        {{ $shipment->tracking_number ?? $shipment->reference_number ?? $shipment->id }}
                        <x-appshell::badge variant="secondary">{{ $shipment->getCarrier()->name() }}</x-appshell::badge>
                    </span>
                    <div class="text-muted" title="{{ __('Last update') }}">
                        {{ show_datetime($shipment->updated_at) }}
                    </div>
                </td>
                <td>
                    <div>
                        <x-appshell::badge variant="primary">{{ $shipment->status()->label() }}</x-appshell::badge>
                    </div>
                    <span class="fst-italic">{{ $shipment->status_message }}</span>
                </td>
            </tr>
        @empty
            <tr>
                <td>{{ __('There are no shipments assigned to this order') }}</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</x-appshell::card>
