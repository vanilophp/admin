<div class="form-group">
    <div class="input-group">
        <span class="input-group-prepend">
            <span class="input-group-text">
                {!! icon('carrier') !!}
            </span>
        </span>
        {{ Form::text('name', null, [
                'class' => 'form-control form-control-lg' . ($errors->has('name') ? ' is-invalid' : ''),
                'placeholder' => __('Name of the carrier')
            ])
        }}
    </div>
    @if ($errors->has('name'))
        <div class="invalid-tooltip">{{ $errors->first('name') }}</div>
    @endif
</div>

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
