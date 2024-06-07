<div class="mb-3">
        {{ Form::text('subtitle', null, [
                'class' => 'form-control form-control-sm' . ($errors->has('subtitle') ? ' is-invalid': ''),
                'placeholder' => __('Subtitle')
            ])
        }}
        @if ($errors->has('subtitle'))
                <div class="invalid-feedback">{{ $errors->first('subtitle') }}</div>
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

<div class="mb-3">
    {{ Form::textarea('description', null, [
            'class' => 'form-control form-control-sm' . ($errors->has('description') ? ' is-invalid' : ''),
            'placeholder' => __('Description'),
            'rows' => 7
        ])
    }}
    @if ($errors->has('description'))
        <div class="invalid-feedback">{{ $errors->first('description') }}</div>
    @endif
</div>

<div class="mb-3">
    {{ Form::textarea('top_content', null, [
            'class' => 'form-control form-control-sm' . ($errors->has('top_content') ? ' is-invalid' : ''),
            'placeholder' => __('Top Content (To be placed on the top of the taxon page)'),
            'rows' => 4
        ])
    }}
    @if ($errors->has('top_content'))
        <div class="invalid-feedback">{{ $errors->first('top_content') }}</div>
    @endif
</div>
<div class="mb-3">
    {{ Form::textarea('bottom_content', null, [
            'class' => 'form-control form-control-sm' . ($errors->has('bottom_content') ? ' is-invalid' : ''),
            'placeholder' => __('Bottom Content (To be placed on the bottom of the taxon page)'),
            'rows' => 4
        ])
    }}
    @if ($errors->has('bottom_content'))
        <div class="invalid-feedback">{{ $errors->first('bottom_content') }}</div>
    @endif
</div>
