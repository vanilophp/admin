<div class="mb-3">
    <div class="input-group input-group-lg {{ $errors->has('name') ? 'has-validation' : '' }}">
        <span class="input-group-text">
            {!! icon('carrier') !!}
        </span>
        <x-appshell::floating-label :label="__('Carrier name')" :is-invalid="$errors->has('name')">
            {{ Form::text('name', null, [
                    'class' => 'form-control form-control-lg' . ($errors->has('name') ? ' is-invalid' : ''),
                    'placeholder' => __('Name of the carrier')
                ])
            }}
        </x-appshell::floating-label>
        @if ($errors->has('name'))
            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
        @endif
    </div>
</div>

<div class="mb-3 row{{ $errors->has('is_active') ? ' has-danger' : '' }}">
    <div class="col-md-10 offset-md-2">
        {{ Form::hidden('is_active', 0) }}

        <div class="form-check form-switch">
            {{ Form::checkbox('is_active', 1, null, ['class' => 'form-check-input', 'id' => 'is-carrier-enabled', 'role' => 'switch']) }}
            <label class="form-check-label" for="is-payment-method-enabled">{{ __('Enabled') }}</label>
        </div>

        @if ($errors->has('is_active'))
            <div class="invalid-feedback">{{ $errors->first('is_active') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="mb-3 row">
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
