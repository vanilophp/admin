<div class="mb-3">
    <div @class(['input-group input-group-lg', 'has-validation' => $errors->has('name')])>
        <span class="input-group-text">{!! icon('percent') !!}</span>
        <x-appshell::floating-label :label="__('Name')" :is-invalid="$errors->has('name')">
            {{ Form::text('name', null, [
                    'class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),
                    'placeholder' => __('Name of the tax rate')
                ])
            }}
        </x-appshell::floating-label>
        @if ($errors->has('name'))
            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
        @endif
    </div>
</div>

<hr>

<x-appshell::card>
    <x-slot:title>{{ __('Criteria') }}</x-slot:title>
    <div class="row mb-3">

        <div class="col col-md-6">
            <label class="form-label">{{ __('Category') }}</label>
            {{ Form::select('tax_category_id', $taxCategories->pluck('name', 'id'), null, [
                    'class' => 'form-select form-select-sm' . ($errors->has('tax_category_id') ? ' is-invalid': ''),
                    'placeholder' => __('--')
               ])
            }}
            @if ($errors->has('tax_category_id'))
                <div class="invalid-feedback">{{ $errors->first('tax_category_id') }}</div>
            @endif
        </div>

        <div class="col col-md-6">
            <label class="form-label">{{ __('Zone') }}</label>
            {{ Form::select('zone_id', $zones->pluck('name', 'id'), null, [
                    'class' => 'form-select form-select-sm' . ($errors->has('zone_id') ? ' is-invalid': ''),
                    'placeholder' => '<' . __('Unrestricted') . '>',
               ])
            }}
            @if ($errors->has('zone_id'))
                <div class="invalid-feedback">{{ $errors->first('zone_id') }}</div>
            @endif
        </div>

    </div>
</x-appshell::card>

<div class="mb-3">
    <?php $validityHasErrors = any_key_exists($errors->toArray(), ['valid_from', 'valid_until']) ?>
    <h5><a data-bs-toggle="collapse" href="#taxratevalidity" class="collapse-toggler-heading"
           @if ($validityHasErrors)
               aria-expanded="true"
            @endif
        >{!! icon('>') !!} {{ __('Validity') }}</a></h5>

    <div id="taxratevalidity" class="collapse{{ $validityHasErrors ? ' show' : '' }}">
        <div class="callout">

            <div class="row">
                <div class="col col-md-6">
                    <label class="form-label">{{ __('Valid from') }}</label>
                    {!! Form::date('valid_from', null, ['class' => 'form-control' . ($errors->has('valid_from') ? ' is-invalid' : '')]) !!}
                    @if ($errors->has('valid_from'))
                        <div class="invalid-feedback">{{ $errors->first('valid_from') }}</div>
                    @endif
                </div>
                <div class="col col-md-6">
                    <label class="form-label">{{ __('Valid until') }}</label>
                    {!! Form::date('valid_until', null, ['class' => 'form-control' . ($errors->has('valid_until') ? ' is-invalid' : '')]) !!}
                    @if ($errors->has('valid_until'))
                        <div class="invalid-feedback">{{ $errors->first('valid_until') }}</div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

<hr>

<div class="mb-3 row{{ $errors->has('is_active') ? ' has-danger' : '' }}">
    <div class="col-md-10 offset-md-2">
        {{ Form::hidden('is_active', 0) }}

        <div class="form-check form-switch">
            {{ Form::checkbox('is_active', 1, null, ['class' => 'form-check-input', 'id' => 'is-shipping-method-active', 'role' => 'switch']) }}
            <label class="form-check-label" for="is-shipping-method-active">{{ __('Enabled') }}</label>
        </div>

        @if ($errors->has('is_active'))
            <div class="invalid-feedback">{{ $errors->first('is_active') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="mb-3 row">
    <label class="col-form-label col-form-label-sm col-md-2">{{ __('Rate') }}</label>
    <div class="col col-md-6 col-lg-4 col-xl-3">
        <div class="input-group">
            {{ Form::text('rate', null, [
                    'class' => 'form-control' . ($errors->has('rate') ? ' is-invalid' : ''),
                ])
            }}
            <span class="input-group-text">%</span>
        </div>
        @if ($errors->has('rate'))
            <input hidden type="hidden" class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('rate') }}</div>
        @endif
    </div>
</div>


<div class="mb-3 row">
    <label class="col-form-label col-form-label-sm col-md-2">{{ __('Calculator') }}</label>
    <div class="col-md-10">
        {{ Form::select('calculator', $calculators, null, [
                'class' => 'form-select form-select-sm' . ($errors->has('calculator') ? ' is-invalid': ''),
                'placeholder' => __('--')
           ])
        }}
        @if ($errors->has('calculator'))
            <div class="invalid-feedback">{{ $errors->first('calculator') }}</div>
        @endif
    </div>
</div>

<div class="mb-3 row">
    <label class="col-form-label col-form-label-sm col-md-2">{{ __('Configuration') }}</label>
    <div class="col-md-10">
        <textarea name="configuration"
                  class="form-control form-control-sm{{ $errors->has('configuration') ? ' is-invalid' : '' }}"
                  placeholder="{{ __('Enter JSON config') }}"
                  rows="6"
        >{{ old('configuration') ?? json_encode(Form::getModel()->configuration ?? [], JSON_PRETTY_PRINT | JSON_FORCE_OBJECT) }}</textarea>
        @if ($errors->has('configuration'))
            <div class="invalid-feedback">{{ $errors->first('configuration') }}</div>
        @endif
    </div>
</div>
