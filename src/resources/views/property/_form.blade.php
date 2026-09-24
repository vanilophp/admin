<div class="mb-3">
    <div class="input-group input-group-lg {{ $errors->has('name') ? 'has-validation' : '' }}">
        <span class="input-group-text">
            {!! icon('property') !!}
        </span>
        <x-appshell::floating-label :label="__('Property name')" :is-invalid="$errors->has('name')">
            {{ Form::text('name', null, [
                'class' => 'form-control form-control-lg' . ($errors->has('name') ? ' is-invalid' : ''),
                'placeholder' => __('Name of the property')
            ])
        }}
        </x-appshell::floating-label>
        @if ($errors->has('name'))
            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
        @endif
    </div>
</div>

<div class="mb-3 row">
    <label class="col-form-label col-form-label-sm col-md-2">{{ __('URL') }}</label>
    <div class="col-md-10">
        {{ Form::text('slug', null, [
                'class' => 'form-control form-control-sm' . ($errors->has('slug') ? ' is-invalid': ''),
                'placeholder' => __('Leave empty to autogenerate')
            ])
        }}
        @if ($errors->has('slug'))
            <div class="invalid-feedback">{{ $errors->first('slug') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="mb-3 row">
    <label class="col-form-label col-form-label-sm col-md-2">{{ __('Type') }}</label>
    <div class="col-md-10">
        {{ Form::select('type', $types, null, [
                'class' => 'form-select form-select-sm' . ($errors->has('type') ? ' is-invalid': ''),
                'placeholder' => __('--')
           ])
        }}
        @if ($errors->has('type'))
            <div class="invalid-feedback">{{ $errors->first('type') }}</div>
        @endif
    </div>
</div>

<div class="mb-3 row{{ $errors->has('is_hidden') ? ' has-danger' : '' }}">
    <div class="col-md-10 offset-md-2">
        {{ Form::hidden('is_hidden', 0) }}

        <div class="form-check form-switch">
            {{ Form::checkbox('is_hidden', 1, null, ['class' => 'form-check-input', 'id' => 'is_property_hidden', 'role' => 'switch']) }}
            <label class="form-check-label" for="is_property_hidden">{{ __('Hidden') }}</label>
        </div>

        @if ($errors->has('is_hidden'))
            <div class="invalid-feedback">{{ $errors->first('is_hidden') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="mb-3">
    <?php $contentHasErrors = any_key_exists($errors->toArray(), ['excerpt', 'description']) ?>
    <h5><a data-bs-toggle="collapse" href="#property-form-content" class="collapse-toggler-heading"
           @if ($contentHasErrors)
               aria-expanded="true"
            @endif
        >{!! icon('>') !!} {{ __('Content') }}</a></h5>

    <div id="property-form-content" class="collapse{{ $contentHasErrors ? ' show' : '' }}">
        <div class="callout">
            <div class="mb-3">
                {{ Form::textarea('excerpt', null, [
                        'class' => 'form-control form-control-sm' . ($errors->has('excerpt') ? ' is-invalid' : ''),
                        'placeholder' => __('Short Description'),
                        'rows' => 4
                    ])
                }}
                @if ($errors->has('excerpt'))
                    <div class="invalid-feedback">{{ $errors->first('excerpt') }}</div>
                @endif
            </div>

            <div class="mb-3">
                {{ Form::textarea('description', null, [
                        'class' => 'form-control form-control-sm' . ($errors->has('description') ? ' is-invalid' : ''),
                        'placeholder' => __('Description'),
                        'rows' => 7
                    ])
                }}
                @if ($errors->has('description'))
                    <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
