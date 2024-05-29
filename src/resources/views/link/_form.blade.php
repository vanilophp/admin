<x-vanilo::sku-lookup model-type-name="target_type" model-id-name="target_id" :sku-label="__('Linked Product')"></x-vanilo::sku-lookup>

<hr>

<section x-data="vaniloLinkTypeWidget">
    <div class="row">
        <label class="form-label col col-md-4 col-xl-2">{{ __('Link Type') }}</label>
        <div class="col col-md-4 col-xl-2">
            <template x-if="wantsToCreateNewType">
                <label class="form-label">{{ __('New Link Type Name') }}</label>
            </template>
        </div>

    </div>
    <div class="row">
        <div class="my-2 col col-md-4 col-xl-2">
            {!! Form::select('link_type', array_merge($linkTypes, ['___create' => __('--New Link Type--')]), null,
                    ['class' => 'form-select', 'x-model' => 'selectedLinkType'])
            !!}
        </div>
        <div class="my-2 col col-md-4 col-xl-2">
            <template x-if="wantsToCreateNewType">
                {!! Form::text('link_type_to_create', null, ['class' => 'form-control']) !!}
            </template>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', function() {
            Alpine.data('vaniloLinkTypeWidget', () => ({
                selectedLinkType: null,
                wantsToCreateNewType() {
                    return this.selectedLinkType === '___create'
                }
            }))
        })
    </script>
@endpush
