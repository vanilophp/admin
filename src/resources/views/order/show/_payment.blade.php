<x-appshell::card>
    <x-slot:title>{{ __('Payment') }}</x-slot:title>

    <table class="table table-striped">
        <tbody>
        @forelse($order->payments as $payment)
            <tr>
                <td>
                        <span class="mb-3 fw-bold" title="{{ $payment->hash }}">
                            <a href="#" title="{{ __('Click to open payment history...') }}"
                               data-bs-toggle="modal" data-bs-target="#payment-history">
                                {{ $payment->getMethod()->getName() }}
                            </a>
                        </span>
                    @if(null !== $payment->subtype)
                        <x-appshell::badge variant="light">
                            <small>{{ $payment->subtype }}</small>
                        </x-appshell::badge>

                    @endif
                    <div class="text-muted">
                        {{ show_datetime($payment->updated_at) }}
                    </div>
                </td>
                <td>
                    <div>
                        <x-appshell::badge variant="primary">{{ $payment->getStatus()->label() }}</x-appshell::badge>
                    </div>
                    <span class="fst-italic">{{ $payment->status_message }}</span>
                </td>
                <td class="text-end">{{ format_price($payment->amount) }}</td>
            </tr>
        @empty
            <tr>
                <td>{{ __('There are no payments assigned to this order') }}</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</x-appshell::card>

@includeWhen($order->payments->isNotEmpty(), 'vanilo::order.show._payment_history')
