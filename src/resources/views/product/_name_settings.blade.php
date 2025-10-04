<div class="bg-light p-3 mb-3 rounded">
    <div class="mb-3">
        <div class="row">
            <div class="col col-md-4 col-lg-3 col-xl-2">
                <label class="col-form-label col-form-label-sm">{{ __('URL Path (slug)') }}</label>
                <x-vanilo::help-tooltip>{{ __('The short, readable part of a product’s web address (like /red-running-shoes). Leave blank to auto-generate from the name.') }}</x-vanilo::help-tooltip>
            </div>
            <div class="col col-md-8 col-lg-9 col-xl-10">
                {{ Form::text('slug', null, [
                'class' => 'form-control form-control-sm' . ($errors->has('slug') ? ' is-invalid': ''),
                'placeholder' => __('URL')
            ])
        }}
                @if ($errors->has('slug'))
                    <div class="invalid-feedback">{{ $errors->first('slug') }}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="mb-3">
        <div class="row">
            <div class="col col-md-4 col-lg-3 col-xl-2">
                <label class="col-form-label col-form-label-sm">{{ __('Title') }}</label>
                <x-vanilo::help-tooltip>{{ __('The title is optional and lets you show shoppers a different title than the product’s name.') }}</x-vanilo::help-tooltip>
            </div>
            <div class="col col-md-8 col-lg-9 col-xl-10">
                {{ Form::text('ext_title', null, [
                'class' => 'form-control form-control-sm' . ($errors->has('ext_title') ? ' is-invalid': ''),
                'placeholder' => __('The title of the product, if it differs from the name')
            ])
        }}
                @if ($errors->has('ext_title'))
                    <div class="invalid-feedback">{{ $errors->first('ext_title') }}</div>
                @endif
            </div>
        </div>
    </div>

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
