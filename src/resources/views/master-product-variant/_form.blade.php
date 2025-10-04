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

<x-vanilo::collapsible-form-block name="subtitle" :label="__('Subtitle')" label-size="6" fields="subtitle">
    <div class="bg-light p-3 mb-3 rounded">
        <div class="mb-3">
            <div class="row">
                <div class="col col-md-4 col-lg-3 col-xl-2">
                    <label class="col-form-label col-form-label-sm">{{ __('Subtitle') }}</label>
                    <x-vanilo::help-tooltip>{{ __('The subtitle is optional and can be used to show an extra single-line description of the product in listings and detail pages.') }}</x-vanilo::help-tooltip>
                </div>
                <div class="col col-md-8 col-lg-9 col-xl-10">
                    {{ Form::text('subtitle', null, [
                    'class' => 'form-control form-control-sm' . ($errors->has('subtitle') ? ' is-invalid': ''),
                    'placeholder' => __('Optional product subtitle')
                ])
            }}
                    @if ($errors->has('subtitle'))
                        <div class="invalid-feedback">{{ $errors->first('subtitle') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-vanilo::collapsible-form-block>

@include('vanilo::product._commerce_attributes', ['model' => $variant])

<div class="px-2 bg-light rounded">
    @include('vanilo::product._settings', ['exclTaxCat' => true])
</div>

<div class="mb-3">
    <x-vanilo::collapsible-form-block name="description" :label="__('Description')" label-size="5" fields="description">
        {{ Form::textarea('description', null,
            [
                'class' => 'form-control' . ($errors->has('description') ? ' is-invalid' : ''),
                'placeholder' => __('Type or copy/paste product description here')
            ]
        ) }}

        @if ($errors->has('description'))
            <div class="invalid-feedback">{{ $errors->first('description') }}</div>
        @endif
    </x-vanilo::collapsible-form-block>
</div>

<div class="mb-3">
    <x-vanilo::collapsible-form-block name="short-description" :label="__('Short Description')" label-size="5" fields="excerpt">
        {{ Form::textarea('excerpt', null, [
            'class' => 'form-control form-control-sm' . ($errors->has('excerpt') ? ' is-invalid' : ''),
            'placeholder' => __('Short Description'),
            'rows' => 4
            ])
        }}
        @if ($errors->has('excerpt'))
            <div class="invalid-feedback">{{ $errors->first('excerpt') }}</div>
        @endif
    </x-vanilo::collapsible-form-block>
</div>

<div class="mb-3">
    <x-vanilo::collapsible-form-block name="seo" :label="__('SEO')" label-size="5" fields="gtin">
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
    </x-vanilo::collapsible-form-block>
</div>
