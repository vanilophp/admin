<div class="col">
    <x-appshell::card-with-icon icon="customer" type="info">
        {{ $order->billpayer->getName() }}
        @if ($order->status->is_cancelled)
            <x-appshell::badge variant="secondary">
                {{ __('cancelled') }}
            </x-appshell::badge>
        @endif
        <x-slot:subtitle>
            {{ $order->number }}
            @if ($order->channel_id)
                | @can('view channels')<a href="{{ route('vanilo.admin.channel.show', $order->channel_id) }}">@endcan
                    <span title="{{ __('Channel of the order') }}">{{ $order->channel?->name }}</span>
                  @can('view channels')</a>@endcan
            @endif
        </x-slot:subtitle>
    </x-appshell::card-with-icon>
</div>

<div class="col">
    <x-appshell::card-with-icon :icon="enum_icon($order->status)" :type="$order->status->is_completed ? 'success' : 'warning'">
        {{ $order->status->label() }}

        <x-slot:subtitle>
            {{ __('Updated') }}
            {{ show_datetime($order->updated_at) }}
            |
            {{ __('Created at') }}
            {{ show_datetime($order->created_at) }}
        </x-slot:subtitle>
    </x-appshell::card-with-icon>
</div>

<div class="col">
    <x-appshell::card-with-icon icon="bag">
        {{ format_price($order->total()) }}
        <x-slot:subtitle>
            {{ trans_choice(':no line on order|:no lines on order',  $order->items->count(), ['no' => $order->items->count()]) }}
        </x-slot:subtitle>
    </x-appshell::card-with-icon>
</div>
