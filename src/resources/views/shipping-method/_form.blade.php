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
        <input hidden class="form-control is-invalid" />
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
