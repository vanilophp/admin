<div class="mb-3">
    <div class="input-group input-group-lg {{ $errors->has('name') ? 'has-validation' : '' }}">
        <span class="input-group-text">
            {!! icon('taxonomy') !!}
        </span>
        <x-appshell::floating-label :label="__('Name')" :is-invalid="$errors->has('name')">
            {{ Form::text('name', null, [
                'class' => 'form-control form-control-lg' . ($errors->has('name') ? ' is-invalid' : ''),
                'placeholder' => __('Name of the Category Tree')
                ])
            }}
        </x-appshell::floating-label>
        @if ($errors->has('name'))
            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="mb-3">
    {{ Form::text('slug', null, [
            'class' => 'form-control form-control-sm' . ($errors->has('slug') ? ' is-invalid': ''),
            'placeholder' => __('URL (leave empty to auto-generate from name)')
        ])
    }}
    @if ($errors->has('slug'))
        <div class="invalid-feedback">{{ $errors->first('slug') }}</div>
    @endif
</div>
