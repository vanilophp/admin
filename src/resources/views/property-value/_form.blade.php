<div class="mb-3">
    <div class="input-group input-group-lg {{ $errors->has('title') ? 'has-validation' : '' }}">
        <span class="input-group-text">
            {!! icon('property-value') !!}
        </span>
        <x-appshell::floating-label :label="__('Title')" :is-invalid="$errors->has('title')">
            {{ Form::text('title', null,
                [
                    'class' => 'form-control form-control-lg' . ($errors->has('title') ? ' is-invalid' : ''),
                    'placeholder' => __('Title')
                ]
            ) }}
        </x-appshell::floating-label>
        @if ($errors->has('title'))
            <div class="invalid-feedback">{{ $errors->first('title') }}</div>
        @endif
    </div>
</div>

<div class="mb-3 row">
    <label class="col-form-label col-form-label-sm col-md-2">{{ __('Value') }}</label>
    <div class="col-md-10">
        {{ Form::text('value', null, [
                'class' => 'form-control form-control-sm' . ($errors->has('value') ? ' is-invalid': ''),
                'placeholder' => __('Leave empty to auto generate from title')
           ])
        }}
        @if ($errors->has('value'))
            <div class="invalid-feedback">{{ $errors->first('value') }}</div>
        @endif
    </div>
</div>

<hr>

@unless($hideProperties ?? false)
<div class="mb-3 row">
    <label class="col-form-label col-form-label-sm col-md-2">{{ __('Property') }}</label>
    <div class="col-md-10">
        {{ Form::select('property_id', $properties, null, [
                'class' => 'form-control form-control-sm' . ($errors->has('property_id') ? ' is-invalid': ''),
                'placeholder' => __('Choose Property')
           ])
        }}
        @if ($errors->has('property_id'))
            <div class="invalid-feedback">{{ $errors->first('property_id') }}</div>
        @endif
    </div>
</div>
@endunless

<div class="mb-3 row">
    <label class="col-form-label col-form-label-sm col-md-2">{{ __('Priority') }}</label>
    <div class="col-md-10">
        {{ Form::text('priority', null, [
                'class' => 'form-control form-control-sm' . ($errors->has('priority') ? ' is-invalid': '')
           ])
        }}
        @if ($errors->has('priority'))
            <div class="invalid-feedback">{{ $errors->first('priority') }}</div>
        @endif
    </div>
</div>

<hr>
