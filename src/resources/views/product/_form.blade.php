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
    <label class="form-control-label col-md-2">{{ __('State') }}</label>
    <div class="col-md-10">
        <?php /*$errors->has('state') ? ' is-invalid' : ''; */ ?>

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
