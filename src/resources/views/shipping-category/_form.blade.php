<div class="mb-3">
    <div @class(['input-group input-group-lg', 'has-validation' => $errors->has('name')])>
        <span class="input-group-text">{!! icon('shipping') !!}</span>
        <x-appshell::floating-label :label="__('Name')" :is-invalid="$errors->has('name')">
            {{ Form::text('name', null, [
                    'class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),
                    'placeholder' => __('Name of the shipping category')
                ])
            }}
        </x-appshell::floating-label>
        @if ($errors->has('name'))
            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
        @endif
    </div>
</div>

<h6 class="mt-5">{{ __('Settings') }}</h6>
<hr>

<div class="mb-3 row{{ $errors->has('is_fragile') ? ' has-danger' : '' }}">
    <div class="col-md-10 offset-md-2">
        {{ Form::hidden('is_fragile', 0) }}

        <div class="form-check form-switch">
            {{ Form::checkbox('is_fragile', 1, null, ['class' => 'form-check-input', 'id' => 'is-shipping-method-fragile', 'role' => 'switch']) }}
            <label class="form-check-label" for="is-shipping-method-fragile">{{ __('Is Fragile') }}</label>
        </div>

        @if ($errors->has('is_fragile'))
            <div class="invalid-feedback">{{ $errors->first('is_fragile') }}</div>
        @endif
    </div>

    <div class="col-md-10 offset-md-2">
        {{ Form::hidden('is_hazardous', 0) }}

        <div class="form-check form-switch">
            {{ Form::checkbox('is_hazardous', 1, null, ['class' => 'form-check-input', 'id' => 'is-shipping-method-hazardous', 'role' => 'switch']) }}
            <label class="form-check-label" for="is-shipping-method-hazardous">{{ __('Is Hazardous') }}</label>
        </div>

        @if ($errors->has('is_hazardous'))
            <div class="invalid-feedback">{{ $errors->first('is_hazardous') }}</div>
        @endif
    </div>
    
    <div class="col-md-10 offset-md-2">
        {{ Form::hidden('is_stackable', 0) }}

        <div class="form-check form-switch">
            {{ Form::checkbox('is_stackable', 1, null, ['class' => 'form-check-input', 'id' => 'is-shipping-method-stackable', 'role' => 'switch']) }}
            <label class="form-check-label" for="is-shipping-method-stackable">{{ __('Is Stackable') }}</label>
        </div>

        @if ($errors->has('is_stackable'))
            <div class="invalid-feedback">{{ $errors->first('is_stackable') }}</div>
        @endif
    </div>

    <div class="col-md-10 offset-md-2">
        {{ Form::hidden('requires_temperature_control', 0) }}

        <div class="form-check form-switch">
            {{ Form::checkbox('requires_temperature_control', 1, null, ['class' => 'form-check-input', 'id' => 'is-shipping-method-requiring-temperature-control', 'role' => 'switch']) }}
            <label class="form-check-label" for="is-shipping-method-requiring-temperature-control">{{ __('Requires Temperature Control') }}</label>
        </div>

        @if ($errors->has('requires_temperature_control'))
            <div class="invalid-feedback">{{ $errors->first('requires_temperature_control') }}</div>
        @endif
    </div>

    <div class="col-md-10 offset-md-2">
        {{ Form::hidden('requires_signature', 0) }}

        <div class="form-check form-switch">
            {{ Form::checkbox('requires_signature', 1, null, ['class' => 'form-check-input', 'id' => 'is-shipping-method-requiring-signature', 'role' => 'switch']) }}
            <label class="form-check-label" for="is-shipping-method-requiring-signature">{{ __('Requires Signature') }}</label>
        </div>

        @if ($errors->has('requires_signature'))
            <div class="invalid-feedback">{{ $errors->first('requires_signature') }}</div>
        @endif
    </div>
</div>

