<div class="mb-3">
    <div @class(['input-group input-group-lg', 'has-validation' => $errors->has('name')])>
        <span class="input-group-text">{!! icon('zone') !!}</span>
        <x-appshell::floating-label :label="__('Name')" :is-invalid="$errors->has('name')">
            {{ Form::text('name', null, [
                    'class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),
                    'placeholder' => __('Name of the zone')
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
    <label class="col-form-label col-form-label-sm col-md-2">{{ __('Scope') }}</label>
    <div class="col-md-10">
        {{ Form::select('scope', $scopes, $zone->scope?->value(), [
                'class' => 'form-select form-select-sm' . ($errors->has('scope') ? ' is-invalid': ''),
                'placeholder' => __('Choose Scope')
           ])
        }}
        @if ($errors->has('scope'))
            <div class="invalid-feedback">{{ $errors->first('scope') }}</div>
        @endif
    </div>
</div>
