<div
    id="item-configuration-{{ $loop->index }}"
    class="modal fade"
    tabindex="-1"
    role="dialog"
    aria-labelledby="item-configuration-title" aria-hidden="true"
>
    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="item-configuration-title">
                    {{ __('Configuration of') }} {{ $item->name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <pre>{{ json_encode($item->configuration(), JSON_PRETTY_PRINT) }}</pre>
            </div>

            <div class="modal-footer">
                <x-appshell::button variant="link" data-bs-dismiss="modal">
                    {{ __('Close') }}
                </x-appshell::button>
            </div>
        </div>
    </div>
</div>
