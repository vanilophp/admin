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
            @if($hasItemAdjustments)
                <th colspan="2">
                    {{ count($itemAdjustmentTypes) === 1 ? end($itemAdjustmentTypes) : __('Adjustments') }}
                </th>
            @endif
            <th class="text-end">{{ __('Subtotal') }}</th>
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

                        @if ($item->hasConfiguration())
                            <button data-bs-toggle="modal" data-bs-target="#item-configuration-{{ $item->id }}" class="btn">{!! icon('settings') !!}</button>
                            @include('vanilo::order.show._item_configuration')
                        @endif
                    @else
                        {{ $item->name }}
                    @endif
                </td>
                <td>{{ $item->quantity }}</td>
                <td>{{ format_price($item->price) }}</td>
                @if($hasItemAdjustments)
                <td class="text-end">
                    @foreach($item->adjustments() as $adjustment)
                        {{ format_price($adjustment->getAmount()) }}<br>
                    @endforeach
                </td>
                <td class="text-start">
                    @foreach($item->adjustments() as $adjustment)
                        <x-appshell::badge variant="secondary"><small>
                            {{ $adjustment->getType()->label() }}:
                            {{ $adjustment->getTitle() }}
                        </small></x-appshell::badge><br>
                    @endforeach
                </td>
                @endif
                <td class="text-end">{{ format_price($item->total) }}</td>
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
                    @if($hasItemAdjustments)<td colspan="2"></td>@endif
                    <td class="text-end">{{ format_price($adjustment->getAmount()) }}</td>
                </tr>
            @endunless
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th colspan="{{ $hasItemAdjustments ? '7' : '5' }}">
                <div class="text-end">{{ __('Order total') }}:</div>
            </th>
            <th class="text-end">{{ format_price($order->total()) }}</th>
        </tr>
        </tfoot>
    </table>

</x-appshell::card>
