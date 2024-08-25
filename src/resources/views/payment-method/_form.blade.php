<div class="mb-3">
    <div class="input-group input-group-lg {{ $errors->has('name') ? 'has-validation' : '' }}">
        <span class="input-group-text">
            {!! icon('payment-method') !!}
        </span>
        <x-appshell::floating-label :label="__('Name')" :is-invalid="$errors->has('name')">
            {{ Form::text('name', null, [
                'class' => 'form-control form-control-lg' . ($errors->has('name') ? ' is-invalid' : ''),
                'placeholder' => __('Name of payment method')
            ])
        }}
        </x-appshell::floating-label>
        @if ($errors->has('name'))
            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
        @endif
    </div>
</div>

<div class="mb-3 row">
    <label class="col-form-label col-form-label-sm col-md-2">{{ __('Gateway') }}</label>
    <div class="col-md-10">
        {{ Form::select('gateway', $gateways, null, [
                'class' => 'form-select form-select-sm' . ($errors->has('gateway') ? ' is-invalid': ''),
                'id' => 'gatewaySelector',
                'placeholder' => __('--')
           ])
        }}
        @if ($errors->has('gateway'))
            <div class="invalid-feedback">{{ $errors->first('gateway') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="mb-3 row{{ $errors->has('is_enabled') ? ' has-danger' : '' }}">
    <div class="col-md-10 offset-md-2">
        {{ Form::hidden('is_enabled', 0) }}

        <div class="form-check form-switch">
            {{ Form::checkbox('is_enabled', 1, null, ['class' => 'form-check-input', 'id' => 'is-payment-method-enabled', 'role' => 'switch']) }}
            <label class="form-check-label" for="is-payment-method-enabled">{{ __('Enabled') }}</label>
        </div>

        @if ($errors->has('is_enabled'))
            <div class="invalid-feedback">{{ $errors->first('is_enabled') }}</div>
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

<x-vanilo::configuration :model="$paymentMethod" reload-on-change-of="gatewaySelector" pass-on-reload="gateway"
                         :sample-refresh-route="route('vanilo.admin.payment-method.create')"></x-vanilo::configuration>
