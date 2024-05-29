<section class="row">
    <div class="my-3 col col-xl-4">
        <label class="form-control-label mb-2">{{ $skuLabel ?? __('Product') }}</label>
        <div class="input-group">
                <span class="input-group-text">
                    {!! icon('sku') !!}
                </span>
            {{ Form::text('sku', null, [
                    'class' => 'form-control',
                    'placeholder' => __('Type SKU (product code)'),
                    'x-model' => 'searchTerm',
                ])
            }}
            <x-appshell::button type="button" variant="outline-secondary" x-on:click="lookupSku()">{{ __('Find by SKU') }}</x-appshell::button>
        </div>
    </div>
    <input type="hidden" x-model="selected.id" name="{{ $modelIdName ?? 'buyable_id' }}" />
    <input type="hidden" x-model="selected.type" name="{{ $modelTypeName ?? 'buyable_type' }}" />
    <div class="my-3 col col-xl-8" x-show="'found' === status">
        <label class="form-control-label">{{ __('Click to select') }}</label>
        <div>
            <template x-for="product in products">
                <article class="d-inline-block border rounded me-1 px-1" x-bind:class="selected.id === product.id ? 'bg-info' : ''" x-on:click="select(product.id, product.morph_type_name)" style="cursor: pointer">
                    <img x-bind:src="product.thumbnail" class="rounded-start" style="height: 2rem" />
                    <span x-text="product.name" class="fw-semibold me-1"></span>
                    <span x-text="product.price + ' {{ config('vanilo.foundation.currency.sign')}}'" class="text-secondary me-1"></span>
                </article>
            </template>
        </div>
    </div>
    <div class="my-3 col col-xl-8" x-show="'empty' === status">
        <div class="alert alert-info">
            {{ __('No products were found by the given SKU') }}
        </div>
    </div>
    <div class="my-3 col col-xl-8" x-show="'progress' === status">
        <label class="form-control-label">&nbsp;</label>
        <p class="placeholder-glow mt-1">
            {{ __('Searching...') }}
            <span class="placeholder w-25"></span>
        </p>
    </div>
    <div class="my-3 col col-xl-8" x-show="'error' === status">
        <div class="alert alert-danger">
            {{ __('There was an error looking up the product') }}<br>
            <span x-text="errorMessage"></span>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', function() {
            Alpine.data('vaniloSkuLookup', () => ({
                products: [],
                searchTerm: null,
                status: "new", // can be: new, progress, found, empty, error
                errorMessage: '',
                selected: {
                    id: null,
                    type: null,
                },
                lookupSku() {
                    this.selected.id = null
                    this.selected.type = null
                    this.status = 'progress'
                    this.errorMessage = ''
                    let url = '{{ route('vanilo.admin.product.index') }}?sku=' + this.searchTerm
                    axios.get(url)
                        .then((response) => {
                            this.products = response.data
                            this.status = this.products.length >= 1 ? 'found' : 'empty'
                        })
                        .catch((error) => {
                            this.status = 'error'
                            this.errorMessage = error.message
                        });
                },
                select(id, type) {
                    this.selected.id = id
                    this.selected.type = type
                },
                readyToSubmit() {
                    return !!this.selected.id
                }
            }))
        })
    </script>
@endpush
