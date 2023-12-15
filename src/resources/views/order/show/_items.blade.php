<div class="card mb-3">
    <div class="card-header">
        {{ __('Ordered Items') }}
    </div>

    <div class="card-body">
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
                    <td>@if($item->product)
                            @if($item->product->masterProduct)
                                <a href="{{ route('vanilo.admin.master_product.show', $item->product->masterProduct) }}">{{ $item->name }}</a>
                            @else
                                <a href="{{ route('vanilo.admin.product.show', $item->product) }}">{{ $item->name }}</a>
                            @endif
                        @else
                            {{ $item->name }}
                        @endif
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
                        <small class="badge badge-pill badge-secondary">{{ $adjustment->getType()->label() }}</small>
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
                    <div class="text-right">{{ __('Order total') }}:</div>
                </th>
                <th>{{ format_price($order->total()) }}</th>
            </tr>
            </tfoot>
        </table>

    </div>
</div>
