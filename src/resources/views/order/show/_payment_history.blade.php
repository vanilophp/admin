<div id="payment-history" class="modal fade" tabindex="-1" role="dialog"
     aria-labelledby="payment-history-title" aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="payment-history-title">
                    {{ __('Payment History') }}
                    <x-appshell::badge variant="light" :title="__('Payment hash')">
                        <small>{{ $payment->hash }}</small>
                    </x-appshell::badge>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" />
            </div>

            <div class="modal-body">
                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th colspan="2">{{ __('Transaction details') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Message') }}</th>
                            <th>{{ __(':gateway Status', ['gateway' => ucfirst($payment->method->gateway)]) }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($payment->history as $entry)
                        <tr>
                            <td>
                                <span class="mb-3 fw-bold" title="{{ $entry->created_at }}">
                                    {{ show_datetime($entry->created_at) }}
                                </span>
                                <div class="text-muted" title="{{ __('Transaction id') }}">
                                    {!! $entry->transaction_number ?: '&nbsp;' !!}
                                </div>
                            </td>
                            <td>
                                <div class="text-muted" title="{{ __('Transaction amount') }}">
                                    {{ sprintf('%.2f %s', $entry->transaction_amount, $payment->getCurrency()) }}
                                </div>
                            </td>
                            <td>
                                <x-appshell::badge variant="primary">{{ $entry->new_status->label() }}</x-appshell::badge>
                            </td>
                            <td><span class="fst-italic">{{ $entry->message }}</span></td>
                            <td>
                                <x-appshell::badge variant="secondary">{{ $entry->native_status }}</x-appshell::badge>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <x-appshell::button variant="link" data-bs-dismiss="modal">{{ __('Close') }}</x-appshell::button>
            </div>
        </div>
    </div>
</div>
