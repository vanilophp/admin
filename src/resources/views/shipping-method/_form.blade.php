<section x-data="shippingMethod">
<div class="mb-3">
    <div class="input-group">
        <span class="input-group-text">
            {!! icon('shipping') !!}
        </span>
        <x-appshell::floating-label :label="__('Name')" :is-invalid="$errors->has('name')">
            {{ Form::text('name', null, [
                    'class' => 'form-control form-control-lg' . ($errors->has('name') ? ' is-invalid' : ''),
                    'placeholder' => __('Name of shipping method')
                ])
            }}
        </x-appshell::floating-label>
    </div>
    @if ($errors->has('name'))
        <input hidden class="form-control is-invalid"/>
        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
    @endif
</div>

<div class="mb-3 row">
    <label class="col-form-label col-form-label-sm col-md-2">{{ __('Carrier') }}</label>
    <div class="col-md-10">
        {{ Form::select('carrier_id', $carriers->pluck('name', 'id'), null, [
                'class' => 'form-select form-select-sm' . ($errors->has('carrier_id') ? ' is-invalid': ''),
                'placeholder' => __('--')
           ])
        }}
        @if ($errors->has('carrier_id'))
            <div class="invalid-feedback">{{ $errors->first('carrier_id') }}</div>
        @endif
    </div>
</div>

<hr>


<div class="mb-3 row{{ $errors->has('is_active') ? ' has-danger' : '' }}">
    <div class="col-md-10 offset-md-2">
        {{ Form::hidden('is_active', 0) }}

        <div class="form-check form-switch">
            {{ Form::checkbox('is_active', 1, null, ['class' => 'form-check-input', 'id' => 'is-shipping-method-active', 'role' => 'switch']) }}
            <label class="form-check-label" for="is-shipping-method-active">{{ __('Enabled') }}</label>
        </div>

        @if ($errors->has('is_active'))
            <div class="invalid-feedback">{{ $errors->first('is_active') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="mb-3 row">
    <label class="col-form-label col-form-label-sm col-md-2">{{ __('Restricted to Zone') }}</label>
    <div class="col-md-10">
        {{ Form::select('zone_id', $zones->pluck('name', 'id'), null, [
                'class' => 'form-select form-select-sm' . ($errors->has('zone_id') ? ' is-invalid': ''),
                'placeholder' => '<' . __('Unrestricted') . '>',
           ])
        }}
        @if ($errors->has('zone_id'))
            <div class="invalid-feedback">{{ $errors->first('zone_id') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="mb-3 row">
    <label class="col-form-label col-form-label-sm col-md-2">{{ __('Shipping Category') }}</label>
    <div class="col-md-10">
        {{ Form::select('shipping_category_id', $shippingCategories->pluck('name', 'id'), null, [
                'class' => 'form-select form-select-sm' . ($errors->has('shipping_category_id') ? ' is-invalid': ''),
                'placeholder' => __('--'),
                'x-model' => 'selectedShippingCategory'
           ])
        }}
        @if ($errors->has('shipping_category_id'))
            <div class="invalid-feedback">{{ $errors->first('shipping_category_id') }}</div>
        @endif
    </div>
</div>

<div class="mb-3 row" x-show="isCategorySelected">
    <label class="col-form-label col-form-label-sm col-md-2">{{ __('Match Products') }}</label>
    <div class="col-md-10">
        @foreach($shippingCategoryMatchingConditions as $key => $value)
            <div class="form-check form-check-inline {{ $errors->has('shipping_category_matching_condition') ? 'is-invalid' : '' }}">
                {{ Form::radio('shipping_category_matching_condition', $key, $shippingMethod->shipping_category_matching_condition && $shippingMethod->shipping_category_matching_condition->value() == $key, ['id' => "shipping_category_matching_condition_$key", 'x-model' => 'shippingCategoryMatchingCondition', 'class' => 'form-check-input' . ($errors->has('shipping_category_matching_condition') ? ' is-invalid': '')]) }}
                <label class="form-check-label" for="shipping_category_matching_condition_{{ $key }}">{{ $value }}</label>
            </div>
        @endforeach

        @if ($errors->has('shipping_category_matching_condition'))
            <div class="invalid-feedback">{{ $errors->first('shipping_category_matching_condition') }}</div>
        @endif
    </div>
</div>

<hr>


<div class="mb-3 row">
    <label class="col-form-label col-form-label-sm col-md-2">{{ __('Calculator') }}</label>
    <div class="col-md-10">
        {{ Form::select('calculator', $calculators, null, [
                'class' => 'form-select form-select-sm' . ($errors->has('calculator') ? ' is-invalid': ''),
                'id' => 'calculatorSelector',
                'placeholder' => __('--')
           ])
        }}
        @if ($errors->has('calculator'))
            <div class="invalid-feedback">{{ $errors->first('calculator') }}</div>
        @endif
    </div>
</div>

<x-vanilo::configuration :model="$shippingMethod" reload-on-change-of="calculatorSelector" pass-on-reload="calculator"
                         :sample-refresh-route="route('vanilo.admin.shipping-method.create')"></x-vanilo::configuration>

<hr>

<div class="mb-3 row">
    <div class="col-md-6 col-xl-4">
        <label for="eta_min" class="col-form-label col-form-label-sm">{{ __('Minimum ETA') }}</label>
        <div>
            {{ Form::number('eta_min', null, [
                    'class' => 'form-control form-control-sm' . ($errors->has('eta_min') ? ' is-invalid': ''),
                    'id' => 'eta_min',
                    'placeholder' => __('--')
               ])
            }}
            @if ($errors->has('eta_min'))
                <div class="invalid-feedback">{{ $errors->first('eta_min') }}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6 col-xl-4">
        <label for="eta_max" class="col-form-label col-form-label-sm">{{ __('Maximum ETA') }}</label>
        <div>
            {{ Form::number('eta_max', null, [
                    'class' => 'form-control form-control-sm' . ($errors->has('eta_max') ? ' is-invalid': ''),
                    'id' => 'eta_max',
                    'placeholder' => __('--')
               ])
            }}
            @if ($errors->has('eta_max'))
                <div class="invalid-feedback">{{ $errors->first('eta_max') }}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6 col-xl-4">
        <label for="eta_units" class="col-form-label col-form-label-sm">{{ __('ETA Units') }}</label>
        <div>
            {{ Form::select('eta_units', $timeUnits, null, [
                    'class' => 'form-select form-select-sm' . ($errors->has('eta_units') ? ' is-invalid': ''),
                    'id' => 'eta_units',
                    'placeholder' => __('--')
               ])
            }}
            @if ($errors->has('eta_units'))
                <div class="invalid-feedback">{{ $errors->first('eta_units') }}</div>
            @endif
        </div>
    </div>
</div>
</section>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', function() {
            Alpine.data('shippingMethod', () => ({
                shippingCategoryMatchingCondition: '{{ old('shipping_category_matching_condition') ?: ($shippingMethod->shipping_category_matching_condition ? $shippingMethod->shipping_category_matching_condition->value() : 'none') }}',
                selectedShippingCategory: '{{ old('shipping_category_id') ?: ($shippingMethod->shipping_category_id ?? '') }}',
                isCategorySelected() {
                    return this.selectedShippingCategory !== '';
                }
            }))
        })
    </script>
@endpush
