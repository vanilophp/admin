<div class="mb-3 row">
    <label class="col-form-label col-form-label-sm col-md-2">{{ __('Type') }}</label>
    <div class="col-md-10">
        {{ Form::select('type', $types, null, [
                'class' => 'form-select form-select-sm' . ($errors->has('type') ? ' is-invalid': ''),
                'placeholder' => __('--')
           ])
        }}
        @if ($errors->has('type'))
            <div class="invalid-feedback">{{ $errors->first('type') }}</div>
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

