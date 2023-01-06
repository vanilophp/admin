<div class="card mb-3">
    <div class="card-body">
        <h6 class="card-title">{{ __('Variants') }}</h6>
            @foreach($product->variants as $variant)
                <a href="{{ route('vanilo.admin.master_product_variant.edit', [$product, $variant]) }}" class="badge badge-secondary">
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
                <a class="btn btn-xs btn-success" href="{{ route('vanilo.admin.master_product_variant.create', $product) }}">
                    {!! icon('+') !!} {{ __('Create variant') }}
                </a>
            @endcan
    </div>
</div>
