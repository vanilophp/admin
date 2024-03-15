<div class="mb-3">

    <div class="input-group input-group-lg {{ $errors->has('name') ? 'has-validation' : '' }}">
        <span class="input-group-text">
            {!! icon('channel') !!}
        </span>
        <x-appshell::floating-label :label="__('Channel name')" :is-invalid="$errors->has('name')">
            {{ Form::text('name', null, [
                    'class' => 'form-control form-control-lg' . ($errors->has('name') ? ' is-invalid' : ''),
                    'placeholder' => __('Name of the channel')
                ])
            }}
        </x-appshell::floating-label>
        @if ($errors->has('name'))
            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
        @endif
    </div>
</div>

<div class="mb-3 row">
    <label class="col-form-label col-form-label-sm col-md-2">{{ __('Slug') }}</label>
    <div class="col-md-10">
        {{ Form::text('slug', null, [
                'class' => 'form-control form-control-sm' . ($errors->has('slug') ? ' is-invalid': ''),
                'placeholder' => __('The human readable id of the channel')
            ])
        }}
        @if ($errors->has('slug'))
            <div class="invalid-feedback">{{ $errors->first('slug') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="mb-3 row">
    <label class="col-form-label col-form-label-sm col-md-2">{{ __('Currency') }}</label>
    <div class="col-md-10">
        {{ Form::select('currency', $currencies, null, [
                'class' => 'form-select form-select-sm' . ($errors->has('currency') ? ' is-invalid': ''),
                'placeholder' => __('--')
           ])
        }}
        @if ($errors->has('currency'))
            <div class="invalid-feedback">{{ $errors->first('currency') }}</div>
        @endif
    </div>
</div>

<div class="mb-3 row">
    <label class="col-form-label col-form-label-sm col-md-2">{{ __('Country') }}</label>
    <div class="col-md-10">
        {{ Form::select('configuration[country_id]', $countries, null, [
                'class' => 'form-select form-select-sm' . ($errors->has('configuration') ? ' is-invalid': ''),
                'placeholder' => __('--')
           ])
        }}
        @if ($errors->has('configuration'))
            <div class="invalid-feedback">{{ $errors->first('configuration') }}</div>
        @endif
    </div>
</div>

<div class="mb-3 row">
    <label class="col-form-label col-form-label-sm col-md-2">{{ __('Domain') }}</label>
    <div class="col-md-10">
        @if(is_array($domains))
        {{ Form::select('domain', $domains, null, [
                'class' => 'form-select form-select-sm' . ($errors->has('domain') ? ' is-invalid': ''),
                'placeholder' => __('--')
           ])
        }}
        @else
        {{ Form::text('domain', null, [
                'class' => 'form-control form-control-sm' . ($errors->has('domain') ? ' is-invalid': ''),
                'placeholder' => __('The domain of the channel')
            ])
        }}
        @endif
        @if ($errors->has('domain'))
            <div class="invalid-feedback">{{ $errors->first('domain') }}</div>
        @endif
    </div>
</div>


@if(null !== $pricelists)
    @include('vanilo::pricelist._select')
@endif
