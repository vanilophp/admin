<div class="mb-3">
    @foreach($zoneMemberTypes as $key => $label)
        <label class="radio-inline" for="member_type_{{ $key }}">
            {{ Form::radio('member_type', $key, ($zoneMember->member_type?->value() === $key), ['id' => "member_type_$key", 'x-model' => 'memberType']) }}
            {{ $label }}
            &nbsp;&nbsp;&nbsp;
        </label>
    @endforeach

    @if ($errors->has('member_type'))
        <div class="alert alert-danger">{{ $errors->first('member_type') }}</div>
    @endif
</div>

<div class="mb-3">
    <div x-show="memberType === 'country'">
        <label class="col-form-label col-form-label-sm col-md-2">{{ __('Country') }}</label>
        <div class="col-md-10">
            {{ Form::select('member_id', $availableCountries, null, [
                    'class' => 'form-control form-control-sm' . ($errors->has('member_id') ? ' is-invalid': ''),
                    'placeholder' => __('Choose a country'),
                    ':disabled' => "memberType !== 'country'",
               ])
            }}
            @if ($errors->has('member_id'))
                <div class="invalid-feedback">{{ $errors->first('member_id') }}</div>
            @endif
        </div>
    </div>

    <div x-show="memberType === 'province'">
        <label class="col-form-label col-form-label-sm col-md-2">{{ __('Province') }}</label>
        <div class="col-md-10">
            {{ Form::select('member_id', $availableProvinces, null, [
                    'class' => 'form-control form-control-sm' . ($errors->has('member_id') ? ' is-invalid': ''),
                    'placeholder' => __('Choose a province'),
                    ':disabled' => "memberType !== 'province'",
               ])
            }}
            @if ($errors->has('member_id'))
                <div class="invalid-feedback">{{ $errors->first('member_id') }}</div>
            @endif
        </div>

    </div>
</div>
