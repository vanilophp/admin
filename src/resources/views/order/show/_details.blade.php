<div class="card mb-3">
    <div class="card-header">
        {{ __('Additional Details') }}
    </div>

    <div class="card-body">
        <h6>{{ __('Customer Notes') }}</h6>
        <div class="font-italic">
            @empty($order->notes)
                -
            @else
                {!! nl2br($order->notes) !!}
            @endempty
        </div>
    </div>
</div>
