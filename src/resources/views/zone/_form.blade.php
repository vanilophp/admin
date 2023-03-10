<div class="form-group">
    <div class="input-group">
        <span class="input-group-prepend">
            <span class="input-group-text">
                {!! icon('zone') !!}
            </span>
        </span>
        {{ Form::text('name', null, [
                'class' => 'form-control form-control-lg' . ($errors->has('name') ? ' is-invalid' : ''),
                'placeholder' => __('Name of the zone')
            ])
        }}
    </div>
    @if ($errors->has('name'))
        <div class="invalid-tooltip">{{ $errors->first('name') }}</div>
    @endif
</div>

<hr>
<div class="form-group row">
    <label class="col-form-label col-form-label-sm col-md-2">{{ __('Scope') }}</label>
    <div class="col-md-10">
        {{ Form::select('scope', $scopes, $zone->scope?->value(), [
                'class' => 'form-control form-control-sm' . ($errors->has('scope') ? ' is-invalid': ''),
                'placeholder' => __('Choose Scope')
           ])
        }}
        @if ($errors->has('scope'))
            <div class="invalid-feedback">{{ $errors->first('scope') }}</div>
        @endif
    </div>
</div>
