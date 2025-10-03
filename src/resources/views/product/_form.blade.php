<div class="mb-3">
    <div class="input-group">
        <span class="input-group-text">
            {!! icon('product') !!}
        </span>
        <x-appshell::floating-label :label="__('Product name')" :is-invalid="$errors->has('name')">
            {{ Form::text('name', null, [
                    'class' => 'form-control form-control-lg' . ($errors->has('name') ? ' is-invalid' : ''),
                    'placeholder' => __('Product name')
                ])
            }}
        </x-appshell::floating-label>
        @if ($errors->has('name'))
            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
        @endif
    </div>
</div>

<hr>

@include('vanilo::product._commerce_attributes', ['model' => $product])

<hr>

<div class="mb-3 row">
    <div class="my-3 col-md-6 col-xl-4">
        <label class="form-control-label">{{ __('State') }}</label>
        <div>
            {{ Form::select('state', $states, null, [
                    'class' => 'form-select form-select-sm' . ($errors->has('state') ? ' is-invalid': ''),
               ])
            }}

            @if ($errors->has('state'))
                <div class="invalid-feedback">{{ $errors->first('state') }}</div>
            @endif
        </div>
    </div>

    <div class="my-3 col-md-6 col-xl-4">
        <label class="form-control-label">{{ __('Tax Category') }}</label>
        <div>
            {{ Form::select('tax_category_id', $taxCategories->pluck('name', 'id'), null, [
                    'class' => 'form-select form-select-sm' . ($errors->has('tax_category_id') ? ' is-invalid': ''),
                    'placeholder' => __('--')
               ])
            }}
            @if ($errors->has('tax_category_id'))
                <div class="invalid-feedback">{{ $errors->first('tax_category_id') }}</div>
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

<div class="mb-3">
    <?php $seoHasErrors = any_key_exists($errors->toArray(), ['ext_title', 'meta_description', 'meta_keywords', 'gtin']) ?>
    <h5><a data-bs-toggle="collapse" href="#product-form-seo" class="collapse-toggler-heading"
           @if ($seoHasErrors)
               aria-expanded="true"
           @endif
        >{!! icon('>') !!} {{ __('SEO') }}</a></h5>

    <div id="product-form-seo" class="collapse{{ $seoHasErrors ? ' show' : '' }}">
        <div class="callout">

            @include('vanilo::product._form_seo')

        </div>
    </div>
</div>

<div class="mb-3">
    <?php $extraHasErrors = any_key_exists($errors->toArray(), ['slug', 'excerpt', 'priority']) ?>
    <h5><a data-bs-toggle="collapse" href="#product-form-extra" class="collapse-toggler-heading"
           @if ($extraHasErrors)
               aria-expanded="true"
           @endif
        >{!! icon('>') !!} {{ __('Extra Settings') }}</a></h5>

    <div id="product-form-extra" class="collapse{{ $extraHasErrors ? ' show' : '' }}">
        <div class="callout">

            @include('vanilo::product._form_extra')

        </div>
    </div>
</div>
