<div class="mb-3">
    {{ Form::text('gtin', null, [
            'class' => 'form-control form-control-sm' . ($errors->has('gtin') ? ' is-invalid' : ''),
            'placeholder' => __('Global Trade Identification Number'),
            'maxlength' => 255,
        ])
    }}
    @if ($errors->has('gtin'))
        <div class="invalid-feedback">{{ $errors->first('gtin') }}</div>
    @endif
</div>
