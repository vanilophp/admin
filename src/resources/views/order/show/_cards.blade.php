@component('appshell::widgets.card_with_icon', [
    'icon' => 'customer',
    'type' => 'info'
])
    {{ $order->billpayer->getName() }}
    @if ($order->status->is_cancelled)
        <small>
                <span class="badge badge-secondary">
                    {{ __('cancelled') }}
                </span>
        </small>
    @endif
    @slot('subtitle')
        {{ $order->number }}
        @if ($order->channel_id)
            | @can('view channels')<a href="{{ route('vanilo.admin.channel.show', $order->channel_id) }}">@endcan
                <span title="{{ __('Channel of the order') }}">{{ $order->channel?->name }}</span>
              @can('view channels')</a>@endcan
        @endif
    @endslot
@endcomponent

@component('appshell::widgets.card_with_icon', [
    'icon' => enum_icon($order->status),
    'type' => $order->status->is_completed ? 'success' : 'warning'
])
    {{ $order->status->label() }}

    @slot('subtitle')
        {{ __('Updated') }}
        {{ show_datetime($order->updated_at) }}
        |
        {{ __('Created at') }}
        {{ show_datetime($order->created_at) }}
    @endslot
@endcomponent

@component('appshell::widgets.card_with_icon', ['icon' => 'bag'])
    {{ format_price($order->total()) }}
    @slot('subtitle')
        {{ trans_choice(':no line on order|:no lines on order',  $order->items->count(), ['no' => $order->items->count()]) }}
    @endslot
@endcomponent
