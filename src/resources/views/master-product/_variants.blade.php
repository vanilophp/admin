<x-appshell::card>
    <x-slot:title>{{ __('Variants') }}</x-slot:title>

    @foreach($product->variants as $variant)
        <a href="{{ route('vanilo.admin.master_product_variant.edit', [$product, $variant]) }}" class="badge bg-secondary">
            @if ($variant->hasImage())
                <img src="{{ $variant->getThumbnailUrl() }}" style="width: 24px; border-radius: 50%" />
            @elseif($product->hasImage())
                <img src="{{ $product->getThumbnailUrl() }}" style="width: 24px; border-radius: 50%" />
            @else
                <svg width="24" height="24" style="border-radius: 50%">
                    <rect width="48" height="48" style="fill:rgb(127,127,127);" />
                </svg>
            @endif
            {{ $variant->name }} <small class="">{{ is_null($variant->price) ? '(!)' : format_price($variant->price) }}</small>
        </a>
    @endforeach

    @can('create products')
        @if(count($product->variants))
            <span class="border-end border-secondary mx-2"></span>&nbsp;
        @endif
        <x-appshell::button href="{{ route('vanilo.admin.master_product_variant.create', $product) }}"
            size="xs" icon="+" variant="success">
            {{ __('Create variant') }}
        </x-appshell::button>
    @endcan
</x-appshell::card>
