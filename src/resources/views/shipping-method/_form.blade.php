<div class="form-group">
    <div class="input-group">
        <span class="input-group-prepend">
            <span class="input-group-text">
                {!! icon('payment-method') !!}
            </span>
        </span>
        {{ Form::text('name', null, [
                'class' => 'form-control form-control-lg' . ($errors->has('name') ? ' is-invalid' : ''),
                'placeholder' => __('Name of payment method')
            ])
        }}
    </div>
    @if ($errors->has('name'))
        <input hidden class="form-control is-invalid" />
        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
    @endif
</div>

<div class="form-group row">
    <label class="col-form-label col-form-label-sm col-md-2">{{ __('Carrier') }}</label>
    <div class="col-md-10">
        {{ Form::select('carrier_id', $carriers->pluck('name', 'id'), null, [
                'class' => 'form-control form-control-sm' . ($errors->has('carrier_id') ? ' is-invalid': ''),
                'placeholder' => __('--')
           ])
        }}
        @if ($errors->has('carrier_id'))
            <div class="invalid-feedback">{{ $errors->first('carrier_id') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="form-group row{{ $errors->has('is_active') ? ' has-danger' : '' }}">
    <div class="col-md-10 offset-md-2">
        {{ Form::hidden('is_active', 0) }}

        <div class="custom-control custom-switch">
            {{ Form::checkbox('is_active', 1, null, ['class' => 'custom-control-input', 'id' => 'is-shipping-method-active']) }}
            <label class="custom-control-label" for="is-shipping-method-active">{{ __('Enabled') }}</label>
        </div>

        @if ($errors->has('is_active'))
            <div class="form-control-feedback">{{ $errors->first('is_active') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="form-group row">
    <label class="col-form-label col-form-label-sm col-md-2">{{ __('Restricted to Zone') }}</label>
    <div class="col-md-10">
        {{ Form::select('zone_id', $zones->pluck('name', 'id'), null, [
                'class' => 'form-control form-control-sm' . ($errors->has('zone_id') ? ' is-invalid': ''),
                'placeholder' => '<' . __('Unrestricted') . '>',
           ])
        }}
        @if ($errors->has('zone_id'))
            <div class="invalid-feedback">{{ $errors->first('zone_id') }}</div>
        @endif
    </div>
</div>

<hr>


<div class="form-group row">
    <label class="col-form-label col-form-label-sm col-md-2">{{ __('Calculator') }}</label>
    <div class="col-md-10">
        {{ Form::select('calculator', $calculators, null, [
                'class' => 'form-control form-control-sm' . ($errors->has('calculator') ? ' is-invalid': ''),
                'placeholder' => __('--')
           ])
        }}
        @if ($errors->has('calculator'))
            <div class="invalid-feedback">{{ $errors->first('calculator') }}</div>
        @endif
    </div>
</div>

<div class="form-group row">
    <label class="col-form-label col-form-label-sm col-md-2">{{ __('Configuration') }}</label>
    <div class="col-md-10">
        <textarea name="configuration"
            class="form-control form-control-sm{{ $errors->has('configuration') ? ' is-invalid' : '' }}"
            placeholder="{{ __('Enter JSON config') }}"
            rows="6"
        >{{ old('configuration') ?? json_encode(Form::getModel()->configuration ?? [], JSON_PRETTY_PRINT | JSON_FORCE_OBJECT) }}</textarea>
        @if ($errors->has('configuration'))
            <div class="invalid-feedback">{{ $errors->first('configuration') }}</div>
        @endif
    </div>
</div>

