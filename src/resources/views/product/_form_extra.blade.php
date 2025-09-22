<div class="row mt-3">
    <div class="col-md-6 col-xl-4">
        <div class="row">
            <label class="col-md-4 col-form-label col-form-label-sm">{{ __('Priority') }}</label>
            <div class="col-md-8">
                {{ Form::number('priority', null, [
                        'class' => 'form-control form-control-sm' . ($errors->has('priority') ? ' is-invalid': ''),
                        'placeholder' => __('Priority')
                    ])
                }}
                @if ($errors->has('priority'))
                    <div class="invalid-feedback">{{ $errors->first('priority') }}</div>
                @endif
            </div>
        </div>
    </div>
</div>

<hr>

<div class="mb-3">
    {{ Form::text('slug', null, [
            'class' => 'form-control form-control-sm' . ($errors->has('slug') ? ' is-invalid': ''),
            'placeholder' => __('URL')
        ])
    }}
    @if ($errors->has('slug'))
        <div class="invalid-feedback">{{ $errors->first('slug') }}</div>
    @endif
</div>

<div class="mb-3">
    {{ Form::textarea('excerpt', null, [
            'class' => 'form-control form-control-sm' . ($errors->has('excerpt') ? ' is-invalid' : ''),
            'placeholder' => __('Short Description'),
            'rows' => 4
        ])
    }}
    @if ($errors->has('excerpt'))
        <div class="invalid-feedback">{{ $errors->first('excerpt') }}</div>
    @endif
</div>
