<div class="card mb-3">
    <div class="card-body">
        <h6 class="card-title">{{ __('Variants') }}</h6>
            @foreach($product->variants as $variant)
                <a href="{{ route('vanilo.admin.master-product-variant.edit', [$product, $variant]) }}" class="badge badge-secondary">{{ $variant->name }}</a>
            @endforeach
            @can('create products')
                <a class="badge badge-success" href="{{ route('vanilo.admin.master-product-variant.create', $product) }}">
                    {!! icon('+') !!} {{ __('Create variant') }}
                </a>
            @endcan
    </div>
</div>
