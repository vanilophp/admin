<x-appshell::card>
    <x-slot:title>{{ __('Ordered Items') }}</x-slot:title>

    <table class="table table-striped">
        <thead>
        <tr>
            <th style="width: 3%"></th>
            <th style="width: 7%">#</th>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Qty') }}</th>
            <th>{{ __('Price') }}</th>
            <th>{{ __('Subtotal') }}</th>
        </tr>
        </thead>

        <tbody>
        @foreach($order->getItems() as $item)
            <tr>
                <td>
                    <input type="checkbox" name="order_item[{{$item->id}}]" />
                </td>
                <td>{{ $loop->iteration }}</td>
                <td>@if($item->product)<a href="{{ route('vanilo.admin.product.show', $item->product) }}">@endif
                        {{ $item->name }}
                        @if($item->product)</a>@endif
                </td>
                <td>{{ $item->quantity }}</td>
                <td>{{ format_price($item->price) }}</td>
                <td>{{ format_price($item->total) }}</td>
            </tr>
        @endforeach
        @foreach($order->adjustments() as $adjustment)
            @unless($adjustment->isIncluded())
                <tr>
                    <td colspan="2">
                        <x-appshell::badge variant="secondary"><small>{{ $adjustment->getType()->label() }}</small></x-appshell::badge>
                    </td>
                    <td>
                        {{ $adjustment->getTitle()}}
                        @if(null !== $adjustment->getOrigin())
                            <small class="text-secondary">[{{ $adjustment->getOrigin() }}]</small>
                        @endif
                    </td>
                    <td>1</td>
                    <td>{{ format_price($adjustment->getAmount()) }}</td>
                    <td>{{ format_price($adjustment->getAmount()) }}</td>
                </tr>
            @endunless
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th colspan="4">
                <div class="text-end">{{ __('Order total') }}:</div>
            </th>
            <th>{{ format_price($order->total()) }}</th>
        </tr>
        </tfoot>
    </table>

</x-appshell::card>
