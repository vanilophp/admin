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
    <div x-show="memberType === 'country'" class="row g-3 align-items-center">
        <label class="col-form-label col-auto">{{ __('Country') }}</label>
        <div class="col-auto">
            {{ Form::select('member_id', $availableCountries, null, [
                    'class' => 'form-select form-select-sm' . ($errors->has('member_id') ? ' is-invalid': ''),
                    'placeholder' => __('Choose a country'),
                    ':disabled' => "memberType !== 'country'",
               ])
            }}
            @if ($errors->has('member_id'))
                <div class="invalid-feedback">{{ $errors->first('member_id') }}</div>
            @endif
        </div>
    </div>

    <div x-show="memberType === 'province'" class="row g-3 align-items-center">
        <label class="col-form-label col-auto">{{ __('Province') }}</label>
        <div class="col-auto">
            {{ Form::select('member_id', $availableProvinces, null, [
                    'class' => 'form-select form-select-sm' . ($errors->has('member_id') ? ' is-invalid': ''),
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
