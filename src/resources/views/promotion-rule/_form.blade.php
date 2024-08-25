<div class="mb-3 row">
    <label class="col-form-label col-form-label-sm col-md-2">{{ __('Type') }}</label>
    <div class="col-md-10">
        {{ Form::select('type', $types, null, [
                'class' => 'form-select form-select-sm' . ($errors->has('type') ? ' is-invalid': ''),
                'id' => 'promotionRuleTypeSelector',
                'placeholder' => __('--')
           ])
        }}
        @if ($errors->has('type'))
            <div class="invalid-feedback">{{ $errors->first('type') }}</div>
        @endif
    </div>
</div>

<hr>

<x-vanilo::configuration :model="$rule" reload-on-change-of="promotionRuleTypeSelector"
     :sample-refresh-route="route('vanilo.admin.promotion.rule.create', $promotion)"></x-vanilo::configuration>
