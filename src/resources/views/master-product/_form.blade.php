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

<div class="mb-3 row">
    <label class="form-control-label col-md-2">{{ __('State') }}</label>
    <div class="col-md-10">

        @foreach($states as $key => $value)
            <label class="radio-inline" for="state_{{ $key }}">
                {{ Form::radio('state', $key, $product->state->value() === $key, ['id' => "state_$key"]) }}
                {{ $value }}
                &nbsp;
            </label>
        @endforeach

        @if ($errors->has('state'))
            <div class="alert alert-danger">{{ $errors->first('state') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="row">
    <div class="mb-3 col-12 col-md-6 col-xl-4">
        <label class="form-control-label">{{ __('Price') }}</label>
        <div class="input-group">
            {{ Form::text('price', null, [
                    'class' => 'form-control' . ($errors->has('price') ? ' is-invalid' : ''),
                    'placeholder' => __('Price')
                ])
            }}
            <span class="input-group-text">
                {{ config('vanilo.foundation.currency.code') }}
            </span>
        </div>
        @if ($errors->has('price'))
            <input type="hidden" class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('price') }}</div>
        @endif
    </div>

    <div class="mb-3 col-12 col-md-6 col-xl-4">
        <label class="form-control-label">{{ __('Original Price') }}</label>
        <div class="input-group">
            {{ Form::text('original_price', null, [
                    'class' => 'form-control' . ($errors->has('original_price') ? ' is-invalid' : ''),
                    'placeholder' => __('optional')
                ])
            }}
            <span class="input-group-text">
                {{ config('vanilo.foundation.currency.code') }}
            </span>
        </div>
        @if ($errors->has('original_price'))
            <input type="hidden" class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('original_price') }}</div>
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

@if($product->exists)
    @include('vanilo::master-product._variants')
@endif

<div class="mb-3">
    <?php $seoHasErrors = any_key_exists($errors->toArray(), ['ext_title', 'meta_description', 'meta_keywords']) ?>
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
    <?php $extraHasErrors = any_key_exists($errors->toArray(), ['slug', 'excerpt']) ?>
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

