<div>
    <label for="title" class="form-label">{{ __('Title') }}</label>

    <div class="mb-3">
        {{ Form::text('title', null, ['class' => 'form-control' . ($errors->has('title') ? ' is-invalid' : ''), 'id' => 'title']) }}

        @if ($errors->has('title'))
            <div class="invalid-feedback">{{ $errors->first('title') }}</div>
        @endif
    </div>
</div>

<div>
    <label for="type" class="form-label">{{ __('Type') }}</label>

    <div class="mb-3">
        {{ Form::select('type', ['video' => 'Video'], null, [
                'class' => 'form-select form-select-sm' . ($errors->has('type') ? ' is-invalid': ''),
                'id' => 'type',
           ])
        }}

        @if ($errors->has('type'))
            <div class="invalid-feedback">{{ $errors->first('type') }}</div>
        @endif
    </div>
</div>

<div>
    <label for="reference" class="form-label">{{ __('Reference') }}</label>

    <div class="mb-3">
        {{ Form::text('reference', null, ['class' => 'form-control' . ($errors->has('reference') ? ' is-invalid' : ''), 'id' => 'reference']) }}

        @if ($errors->has('reference'))
            <div class="invalid-feedback">{{ $errors->first('reference') }}</div>
        @endif
    </div>
</div>

<div class="mb-3 row{{ $errors->has('is_published') ? ' has-danger' : '' }}">
    <div class="col-md-10">
        {{ Form::hidden('is_published', 0) }}

        <div class="form-check form-switch">
            <label for="is_published" class="form-check-label" for="is_property_hidden">{{ __('Published') }}</label>
            {{ Form::checkbox('is_published', 1, null, ['class' => 'form-check-input', 'id' => 'is_published', 'role' => 'switch']) }}
        </div>

        @if ($errors->has('is_published'))
            <div class="invalid-feedback">{{ $errors->first('is_published') }}</div>
        @endif
    </div>
</div>
