<div class="mb-3">
    {{ Form::text('ext_title', null, [
            'class' => 'form-control form-control-sm' . ($errors->has('ext_title') ? ' is-invalid': ''),
            'placeholder' => __('Extended/SEO Title')
        ])
    }}
    @if ($errors->has('ext_title'))
        <div class="invalid-feedback">{{ $errors->first('ext_title') }}</div>
    @endif
</div>

<div class="mb-3">
    {{ Form::textarea('meta_description', null, [
            'class' => 'form-control form-control-sm' . ($errors->has('meta_description') ? ' is-invalid' : ''),
            'placeholder' => __('Meta Description'),
            'rows' => 4
        ])
    }}
    @if ($errors->has('meta_description'))
        <div class="invalid-feedback">{{ $errors->first('meta_description') }}</div>
    @endif
</div>

<div class="mb-3">
    {{ Form::text('meta_keywords', null, [
            'class' => 'form-control form-control-sm' . ($errors->has('meta_keywords') ? ' is-invalid' : ''),
            'placeholder' => __('Meta Keywords, separated by commas')
        ])
    }}
    @if ($errors->has('meta_keywords'))
        <div class="invalid-feedback">{{ $errors->first('meta_keywords') }}</div>
    @endif
</div>

@if (request()->routeIs('vanilo.admin.product.edit') || request()->routeIs('vanilo.admin.product.create'))
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
@endif
