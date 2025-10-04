<?php
    $exclTaxCat ??= false;
    $colClasses = $exclTaxCat ? 'my-3 col-md-6 col-xl-4' : 'my-3 col-md-6 col-xl-3';
?>
<div class="mb-3 row">
    <div class="{{ $colClasses }}">
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

    <div class="{{ $colClasses }}">
        <label class="form-control-label">{{ __('Priority') }}</label>
        <div>
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

    @unless($exclTaxCat)
    <div class="{{ $colClasses }}">
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
    @endunless

    <div class="{{ $colClasses }}">
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
