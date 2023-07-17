<div class="col">
    <x-appshell::card class="h-100">
        <x-slot:title>{{ __('Additional Details') }}</x-slot:title>

        <h6>{{ __('Customer Notes') }}</h6>
        <div class="fst-italic">
            @empty($order->notes)
                -
            @else
                {!! nl2br($order->notes) !!}
            @endempty
        </div>
    </x-appshell::card>
</div>
