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
                    [
                        'class' => 'form-select'  . ($errors->has('link_type') ? ' is-invalid': ''),
                        'x-model' => 'selectedLinkType',
                        'placeholder' => '--'])
            !!}
            @if ($errors->has('link_type'))
                <div class="invalid-feedback">{{ $errors->first('link_type') }}</div>
            @endif
        </div>
        <div class="my-2 col col-md-4 col-xl-2">
            <template x-if="wantsToCreateNewType">
                {!! Form::text('link_type_to_create', null, ['class' => 'form-control']) !!}
            </template>
        </div>
    </div>
    <div class="mt-2 d-flex">
        <div class="form-check form-switch">
            {{ Form::checkbox('omnidirectional', 1, null, ['class' => 'form-check-input', 'id' => 'is-omnidirectional', 'role' => 'switch', 'x-model' => 'isOmnidirectional']) }}
            <label class="form-check-label" for="is-omnidirectional">{{ __('Omnidirectional') }}</label>
        </div>
        <div class="form-check">
            {!! icon(
                'help',
                'info',
                [
                    'data-bs-toggle' => 'tooltip',
                    'data-bs-placement' => 'right',
                    'data-bs-title' => __('Omnidirectional means that all products are linking back to each other. Useful for cases like \'similar\' products')
                ]
            ) !!}
        </div>
    </div>
</section>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', function() {
            Alpine.data('vaniloLinkTypeWidget', () => ({
                selectedLinkType: @json(empty($linkTypes) ? '___create' : null),
                wantsToCreateNewType() {
                    return this.selectedLinkType === '___create'
                }
            }))
        })
    </script>
@endpush

@push('onload-scripts')
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
@endpush()
