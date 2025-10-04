<?php
    $backorder = old('backorder', $model->backorder);
    $backorderEnabled = (0 !== $backorder && 0.0 !== $backorder); // In PHP 0.0 !== 0 !
    $backorderUnlimited = is_null($backorder);
?>

<section x-data="commercialAttributes">
    <div class="row">
        <div class="my-3 col-md-6 col-xl-4">
            <label class="form-control-label">{{ __('SKU') }}*</label>
            <div class="input-group">
                <span class="input-group-text">
                    {!! icon('sku') !!}
                </span>
                {{ Form::text('sku', null, [
                        'class' => 'form-control' . ($errors->has('sku') ? ' is-invalid' : ''),
                        'placeholder' => __('SKU (product code)')
                    ])
                }}
            </div>
            @if ($errors->has('sku'))
                <input hidden class="form-control is-invalid">
                <div class="invalid-feedback">{{ $errors->first('sku') }}</div>
            @endif
        </div>

        <div class="my-3 col-md-6 col-xl-4">
            <label class="form-control-label">{{ __('Stock') }}</label>
            <div class="input-group">
                <span class="input-group-text">
                    {!! icon('stock') !!}
                </span>
                {{ Form::number('stock', null, [
                        'class' => 'form-control' . ($errors->has('stock') ? ' is-invalid' : ''),
                        'placeholder' => __('Product Stock Count'),
                        'x-model' => 'stock'
                    ])
                }}
            </div>
            @if ($errors->has('stock'))
                <input hidden class="form-control is-invalid">
                <div class="invalid-feedback">{{ $errors->first('stock') }}</div>
            @endif
        </div>

        <div class="py-3 col-md-6 col-xl-4 bg-light rounded-start rounded-xl-start-0 rounded-xl-top ">
            <label class="form-control-label">
                {{ __('Backorder') }}
                <x-vanilo::help-tooltip>{{ __('Backorder defines what happens once the stock has depleted') }}</x-vanilo::help-tooltip>
            </label>

            <div class="input-group mb-3">
                <div class="input-group-text">
                    <div class="form-check form-check-inline form-switch">
                        <input x-on:change="switchBackorder()" class="form-check-input" type="checkbox" role="switch" id="backorderEnableCheck" @checked($backorderEnabled)>
                    </div>
                </div>
                {{ Form::number('backorder', null, [
                                'class' => 'form-control' . ($errors->has('backorder') ? ' is-invalid' : ''),
                                'placeholder' => __('Max Backorder'),
                                'min' => 0,
                                'x-model.number' => 'backorder',
                                'x-bind:readonly' => '!backorderEnabled || backorderUnlimited',
                                'x-bind:class' => '(!backorderEnabled || backorderUnlimited) ? "bg-light text-secondary text-opacity-25" : ""',
                            ])
                        }}
                <div class="input-group-text" x-show="backorderEnabled">
                    <input x-on:change="switchBackorderUnlimited()" class="form-check-input mt-0" type="checkbox" value="1" aria-label="Unlimited" id="backOrderUnlimitedCheckbox" x-on:change="switchBackorder()" @checked($backorderUnlimited)>
                    <label class="form-check-label ps-1" for="backOrderUnlimitedCheckbox">{{ __('Unlimited') }}</label>
                </div>
            </div>
            @if ($errors->has('backorder'))
                <input hidden class="form-control is-invalid">
                <div class="invalid-feedback">{{ $errors->first('backorder') }}</div>
            @endif
        </div>

        <div class="pt-3 col-md-6 d-xl-none bg-light rounded-end">
            <x-appshell::alert variant="info">
                {!! icon('info') !!}
                <span x-text="infoMessage"></span>
            </x-appshell::alert>
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-6 col-xl-4">
            <label class="form-control-label">{{ __('Price') }}</label>
            <div class="input-group">
                {{ Form::text('price', null, [
                        'class' => 'form-control' . ($errors->has('price') ? ' is-invalid' : ''),
                        'placeholder' => __('Price')
                    ])
                }}
                <span class="input-group-text">
                    {{ config('vanilo.foundation.currency.code') }}
                </span>
            </div>
            @if ($errors->has('price'))
                <input type="hidden" class="form-control is-invalid">
                <div class="invalid-feedback">{{ $errors->first('price') }}</div>
            @endif
        </div>

        <div class="mb-3 col-md-6 col-xl-4">
            <label class="form-control-label">{{ __('Original Price') }}</label>
            <div class="input-group">
                {{ Form::text('original_price', null, [
                        'class' => 'form-control' . ($errors->has('original_price') ? ' is-invalid' : ''),
                        'placeholder' => __('optional')
                    ])
                }}
                <span class="input-group-text">
                    {{ config('vanilo.foundation.currency.code') }}
                </span>
            </div>
            @if ($errors->has('original_price'))
                <input type="hidden" class="form-control is-invalid">
                <div class="invalid-feedback">{{ $errors->first('original_price') }}</div>
            @endif
        </div>

        <div class="mb-3 d-none d-xl-block col-xl-4 bg-light rounded-bottom">
            <x-appshell::alert variant="info">
                {!! icon('info') !!}
                <span x-text="infoMessage"></span>
            </x-appshell::alert>
        </div>
    </div>
</section>

<style>
    @media (min-width: 1200px) {
        .rounded-xl-start-0 {
            border-bottom-left-radius: 0 !important;
            border-top-left-radius: 0 !important;
        }

        .rounded-xl-top {
            border-top-left-radius: var(--bs-border-radius) !important;
            border-top-right-radius: var(--bs-border-radius) !important;
        }
    }
</style>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', function() {
            Alpine.data('commercialAttributes', () => ({
                infoMessage() {
                    if (0 === this.backorder || "0" === this.backorder) {
                        return "{{ __('If the stock reaches 0, the product can not be purchased.') }}"
                    }
                    if (null === this.backorder) {
                        return "{{ __('The product can be purchased without limitations even after the stock reaches 0.') }}"
                    }

                    return "{{ __(':num additional units can be ordered after the stock reaches 0.') }}".replace(':num', this.backorder)
                },
                backorderEnabled: @json($backorderEnabled),
                backorderUnlimited: @json($backorderUnlimited),
                switchBackorderUnlimited() {
                    if (this.backorderUnlimited) {
                        this.backorder = null === this.originalBackorder ? 1 : this.originalBackorder
                    } else {
                        this.backorder = null
                    }

                    this.backorderUnlimited = !this.backorderUnlimited
                },
                switchBackorder() {
                    if (this.backorderEnabled) {
                        this.backorder = 0
                    } else {
                        this.backorder = 0 === this.originalBackorder ? null : this.originalBackorder
                    }

                    this.backorderUnlimited = null === this.backorder
                    this.backorderEnabled = !this.backorderEnabled
                    let unlimitedCheckbox = document.getElementById('backOrderUnlimitedCheckbox');
                    if (this.backorderUnlimited && !unlimitedCheckbox.checked) {
                        unlimitedCheckbox.checked = true
                    }
                },
                originalBackorder: @json($backorder),
                backorder: @json($backorder),
                stock: {{ json_encode((int) (old('stock') ?? $model->stock)) }}
            }))
        })
    </script>
@endpush
