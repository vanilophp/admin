<div class="mb-3">
    <div class="input-group">
        <span class="input-group-text">
            {!! icon('product') !!}
        </span>
        <x-appshell::floating-label :label="__('Product name') . '*'" :is-invalid="$errors->has('name')">
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

<x-vanilo::collapsible-form-block name="name-settings" :label="__('Title & URL Settings')" label-size="6" :fields="['slug', 'ext_title', 'subtitle']">
    @include('vanilo::product._name_settings')
</x-vanilo::collapsible-form-block>

@include('vanilo::product._commerce_attributes', ['model' => $product])

<div class="px-2 bg-light rounded">
    @include('vanilo::product._settings')
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
    <x-vanilo::collapsible-form-block name="seo" :label="__('SEO')" label-size="5" fields="meta_description,meta_keywords,gtin">
            @include('vanilo::product._form_seo')
    </x-vanilo::collapsible-form-block>
</div>
