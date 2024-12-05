<div class="mb-3">
    <div class="input-group">
        <span class="input-group-text">
            {!! icon('product') !!}
        </span>
        <x-appshell::floating-label :label="__('Variant name')" :is-invalid="$errors->has('name')">
        {{ Form::text('name', null, [
                'class' => 'form-control form-control-lg' . ($errors->has('name') ? ' is-invalid' : ''),
                'placeholder' => __('Variant name')
            ])
        }}
        </x-appshell::floating-label>
        @if ($errors->has('name'))
            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
        @endif
    </div>
</div>

<hr>

@include('vanilo::product._commerce_attributes', ['model' => $variant])

<hr>

<div class="mb-3 row">
    <label class="col-form-label col-form-label-sm col-md-2">{{ __('State') }}</label>
    <div class="col-md-4">
        {{ Form::select('state', $states, null, [
                'class' => 'form-select form-select-sm' . ($errors->has('state') ? ' is-invalid': ''),
           ])
        }}

        @if ($errors->has('state'))
            <div class="invalid-feedback">{{ $errors->first('state') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="mb-3">
    <label class="form-control-label">{{ __('Description') }}</label>

    {{ Form::textarea('description', null,
            [
                'class' => 'form-control' . ($errors->has('description') ? ' is-invalid' : ''),
                'placeholder' => __('Type or copy/paste product description here')
            ]
    ) }}

    @if ($errors->has('description'))
        <div class="invalid-feedback">{{ $errors->first('description') }}</div>
    @endif
</div>

<hr>

<div class="mb-3">
    <label class="form-control-label text-muted">{{ __('Short Description') }} ({{ __('optional') }})</label>
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
