{{--@php(dd($errors))--}}

<div class="mb-3">
    <div class="input-group input-group-lg {{ $errors->has('name') ? 'has-validation' : '' }}">
        <span class="input-group-text">
            {!! icon('promotion') !!}
        </span>
        <x-appshell::floating-label :label="__('Promotion name')" :is-invalid="$errors->has('name')">
            {{ Form::text('name', null, [
                    'class' => 'form-control form-control-lg' . ($errors->has('name') ? ' is-invalid' : ''),
                    'placeholder' => __('Name of the promotion')
                ])
            }}
        </x-appshell::floating-label>
        @if ($errors->has('name'))
            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
        @endif
    </div>
</div>

<div class="row">
    <div class="my-3 col-md-6 col-xl-4">
        <label class="form-control-label">{{ __('Starts') }}</label>

        <input
          type="datetime-local"
          id="meeting-time"
          name="starts_at"
          value="{{ old('starts_at', $promotion->starts_at) }}"
          class="form-control {{ $errors->has('starts_at') ? 'is-invalid' : '' }}"
        />

        @if ($errors->has('starts_at'))
            <input hidden class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('starts_at') }}</div>
        @endif
    </div>

    <div class="my-3 col-md-6 col-xl-4">
        <label class="form-control-label">{{ __('Ends') }}</label>

        <input
          type="datetime-local"
          id="meeting-time"
          name="ends_at"
          value="{{ old('ends_at', $promotion->ends_at) }}"
          class="form-control {{ $errors->has('ends_at') ? 'is-invalid' : '' }}"
        />

        @if ($errors->has('ends_at'))
            <input hidden class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('ends_at') }}</div>
        @endif
    </div>
</div>

<div class="row">
    <div class="my-3 col-md-6 col-xl-4">
        <label class="form-control-label">{{ __('Priority') }}</label>
        <div class="input-group">
                <span class="input-group-text">
                    {!! icon('stock') !!}
                </span>
            {{ Form::number('priority', null, [
                    'class' => 'form-control' . ($errors->has('priority') ? ' is-invalid' : ''),
                    'placeholder' => __('Priority'),
                ])
            }}
        </div>
        @if ($errors->has('priority'))
            <input hidden class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('priority') }}</div>
        @endif
    </div>

    <div x-data="usageLimitField" class="my-3 col-md-6 col-xl-4">
        <label class="form-control-label">{{ __('Usage Limit') }}</label>

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

        @if ($errors->has('usage_limit'))
            <input hidden class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('usage_limit') }}</div>
        @endif
    </div>
</div>

<div class="row">
    <div class="my-3 col-md-6 col-xl-4">
        <label class="form-control-label">{{ __('Exclusive') }}</label>
        {{ Form::hidden('is_exclusive', 0) }}

        <div class="form-check form-switch">
            {{ Form::checkbox('is_exclusive', 1, null, ['class' => 'form-check-input', 'id' => 'is-exclusive', 'role' => 'switch']) }}
        </div>

        @if ($errors->has('is_exclusive'))
            <div class="invalid-feedback">{{ $errors->first('is_exclusive') }}</div>
        @endif
    </div>

    <div class="my-3 col-md-6 col-xl-4">
        <label class="form-control-label">{{ __('Coupon Based') }}</label>
        {{ Form::hidden('is_coupon_based', 0) }}

        <div class="form-check form-switch">
            {{ Form::checkbox('is_coupon_based', 1, null, ['class' => 'form-check-input', 'id' => 'is-coupon-based', 'role' => 'switch']) }}
        </div>

        @if ($errors->has('is_coupon_based'))
            <div class="invalid-feedback">{{ $errors->first('is_coupon_based') }}</div>
        @endif
    </div>

    <div class="my-3 col-md-6 col-xl-4">
        <label class="form-control-label">{{ __('Applies to Discounted') }}</label>
        {{ Form::hidden('applies_to_discounted', 0) }}

        <div class="form-check form-switch">
            {{ Form::checkbox('applies_to_discounted', 1, null, ['class' => 'form-check-input', 'id' => 'applies-to-discounted', 'role' => 'switch']) }}
        </div>

        @if ($errors->has('applies_to_discounted'))
            <div class="invalid-feedback">{{ $errors->first('applies_to_discounted') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="mb-3">
    <label class="form-control-label">{{ __('Description') }}</label>

    {{
        Form::textarea(
            'description',
            null,
            [
                'class' => 'form-control' . ($errors->has('description') ? ' is-invalid' : ''),
                'placeholder' => __('Type the promotion description here')
            ]
        )
    }}

    @if ($errors->has('description'))
        <div class="invalid-feedback">{{ $errors->first('description') }}</div>
    @endif
</div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', function() {
            Alpine.data('usageLimitField', () => ({
                isUsageIsUnlimited: @json(is_null(old('usage_limit', $promotion->usage_limit))),
                usageLimit: @json(old('usage_limit', $promotion->usage_limit)),
                originalUsageLimitValue: @json(old('usage_limit', $promotion->usage_limit)),

                toggleUsageLimitMode() {
                    if (this.isUsageIsUnlimited === true) {
                        this.usageLimit = null
                    } else {
                        this.usageLimit = this.originalUsageLimitValue ?? 0
                    }
                }
            }))
        })
    </script>
@endpush
