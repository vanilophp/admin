<div class="mb-3 row">
    <label class="col-form-label col-md-2">{{ __('Code') }}</label>
    <div class="col-md-10">
        {{ Form::text('code', null, [
                'class' => 'form-control form-control-sm' . ($errors->has('code') ? ' is-invalid': ''),
                'placeholder' => __('Code')
            ])
        }}
        @if ($errors->has('code'))
            <div class="invalid-feedback">{{ $errors->first('code') }}</div>
        @endif
    </div>
</div>

<div x-data="usageLimitField" class="mb-3 row">
    <label class="col-form-label col-md-2">{{ __('Usage Limit') }}</label>

    <div class="col-md-10">
        <div class="input-group">
            <span class="input-group-text">
                {!! icon('stock') !!}
            </span>
            {{ Form::number('usage_limit', null, [
                    'class' => 'form-control' . ($errors->has('usage_limit') ? ' is-invalid' : ''),
                    'placeholder' => __('Usage Limit'),
                    'min' => 0,
                    'x-model.number' => 'usageLimit',
                    'x-bind:readonly' => 'isUsageIsUnlimited',
                    'x-bind:class' => 'isUsageIsUnlimited ? "bg-light text-secondary text-opacity-25" : ""'
                ])
            }}
            <div class="input-group-text">
                <input
                    x-model="isUsageIsUnlimited"
                    x-on:change="toggleUsageLimitMode"
                    class="form-check-input mt-0"
                    type="checkbox"
                    value="1"
                    aria-label="Unlimited"
                    id="usageUnlimitedCheckbox"
                >
                <label class="form-check-label ps-1" for="usageUnlimitedCheckbox">{{ __('Unlimited') }}</label>
            </div>
        </div>
    </div>

    @if ($errors->has('usage_limit'))
        <input hidden class="form-control is-invalid">
        <div class="invalid-feedback">{{ $errors->first('usage_limit') }}</div>
    @endif
</div>

<div x-data="perCustomerUsageLimitField" class="mb-3 row">
    <label class="col-form-label col-md-2">{{ __('Per Customer Usage Limit') }}</label>

    <div class="col-md-10">
        <div class="input-group">
            <span class="input-group-text">
                {!! icon('stock') !!}
            </span>
            {{ Form::number('per_customer_usage_limit', null, [
                    'class' => 'form-control' . ($errors->has('per_customer_usage_limit') ? ' is-invalid' : ''),
                    'placeholder' => __('Per Customer Usage Limit'),
                    'min' => 0,
                    'x-model.number' => 'perCustomerUsageLimit',
                    'x-bind:readonly' => 'isPerCustomerUsageIsUnlimited',
                    'x-bind:class' => 'isPerCustomerUsageIsUnlimited ? "bg-light text-secondary text-opacity-25" : ""'
                ])
            }}
            <div class="input-group-text">
                <input
                    x-model="isPerCustomerUsageIsUnlimited"
                    x-on:change="togglePerCustomerUsageLimitMode"
                    class="form-check-input mt-0"
                    type="checkbox"
                    value="1"
                    aria-label="Unlimited"
                    id="perCustomerUsageUnlimitedCheckbox"
                >
                <label class="form-check-label ps-1" for="perCustomerUsageUnlimitedCheckbox">{{ __('Unlimited') }}</label>
            </div>
        </div>
    </div>

    @if ($errors->has('per_customer_usage_limit'))
        <input hidden class="form-control is-invalid">
        <div class="invalid-feedback">{{ $errors->first('per_customer_usage_limit') }}</div>
    @endif
</div>

<div class="mb-3 row">
    <label class="col-form-label col-md-2">{{ __('Expires at') }}</label>
    <div class="col-md-10">
        <input
            type="datetime-local"
            name="expires_at"
            value="{{ old('expires_at', $coupon->expires_at) }}"
            class="form-control {{ $errors->has('expires_at') ? 'is-invalid' : '' }}"
        />

        @if ($errors->has('expires_at'))
            <div class="invalid-feedback">{{ $errors->first('expires_at') }}</div>
        @endif
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', function () {
            Alpine.data('usageLimitField', () => ({
                isUsageIsUnlimited: @json(is_null(old('usage_limit', $coupon->usage_limit))),
                usageLimit: @json(old('usage_limit', $coupon->usage_limit)),
                originalUsageLimitValue: @json(old('usage_limit', $coupon->usage_limit)),

                toggleUsageLimitMode() {
                    if (this.isUsageIsUnlimited === true) {
                        this.usageLimit = null
                    } else {
                        this.usageLimit = this.originalUsageLimitValue ?? 0
                    }
                }
            }))

            Alpine.data('perCustomerUsageLimitField', () => ({
                isPerCustomerUsageIsUnlimited: @json(is_null(old('per_customer_usage_limit', $coupon->per_customer_usage_limit))),
                perCustomerUsageLimit: @json(old('per_customer_usage_limit', $coupon->per_customer_usage_limit)),
                originalPerCustomerUsageLimitValue: @json(old('per_customer_usage_limit', $coupon->per_customer_usage_limit)),

                togglePerCustomerUsageLimitMode() {
                    if (this.isPerCustomerUsageIsUnlimited === true) {
                        this.perCustomerUsageLimit = null
                    } else {
                        this.perCustomerUsageLimit = this.originalPerCustomerUsageLimitValue ?? 0
                    }
                }
            }))
        })
    </script>
@endpush
