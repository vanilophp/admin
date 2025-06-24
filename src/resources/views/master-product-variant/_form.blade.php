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
    <div class="my-3 col-md-6 col-xl-4">
        <label class="form-control-label">{{ __('State') }}</label>
        <div>
            {{ Form::select('state', $states, null, [
                    'class' => 'form-select form-select-sm' . ($errors->has('state') ? ' is-invalid': ''),
                    'placeholder' => __('--'),
               ])
            }}

            @if ($errors->has('state'))
                <div class="invalid-feedback">{{ $errors->first('state') }}</div>
            @endif
        </div>
    </div>

    <div class="my-3 col-md-6 col-xl-4">
        <label class="form-control-label">{{ __('Shipping Category') }}</label>
        <div>
            {{ Form::select('shipping_category_id', $shippingCategories->pluck('name', 'id'), null, [
                    'class' => 'form-select form-select-sm' . ($errors->has('shipping_category_id') ? ' is-invalid': ''),
                    'placeholder' => __('--')
               ])
            }}
            @if ($errors->has('shipping_category_id'))
                <div class="invalid-feedback">{{ $errors->first('shipping_category_id') }}</div>
            @endif
        </div>
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

<div class="mb-3">
    <?php $seoHasErrors = any_key_exists($errors->toArray(), ['gtin']) ?>
    <h5><a data-bs-toggle="collapse" href="#master-product-variant-form-seo" class="collapse-toggler-heading"
           @if ($seoHasErrors)
               aria-expanded="true"
           @endif
        >{!! icon('>') !!} {{ __('SEO') }}</a></h5>

    <div id="master-product-variant-form-seo" class="collapse{{ $seoHasErrors ? ' show' : '' }}">
        <div class="callout">

            @include('vanilo::master-product-variant._form_seo')

        </div>
    </div>
</div>
