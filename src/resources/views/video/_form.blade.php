<div class="mb-3">
    <label for="title" class="form-label">{{ __('Title') }}</label>

    {{ Form::text('title', null, ['class' => 'form-control' . ($errorBag->has('title') ? ' is-invalid' : ''), 'id' => 'title']) }}

    @if ($errorBag->has('title'))
        <div class="invalid-feedback">{{ $errorBag->first('title') }}</div>
    @endif
</div>

<div class="mb-3">
    <label for="driver" class="form-label">{{ __('Type') }}</label>

    {{ Form::select('driver', array_map(fn($driver) => $driver['name'], vnl_video_drivers()), null, [
            'class' => 'form-select form-select-sm' . ($errorBag->has('driver') ? ' is-invalid': ''),
            'id' => 'driver',
            'x-model' => 'driver'
       ])
    }}

    @if ($errorBag->has('driver'))
        <div class="invalid-feedback">{{ $errorBag->first('driver') }}</div>
    @endif
</div>

<div class="mb-3">
    <label for="reference" class="form-label" x-text="referenceLabel">{{ __('Reference') }}</label>

    {{ Form::text('reference', null, ['class' => 'form-control' . ($errorBag->has('reference') ? ' is-invalid' : ''), 'id' => 'reference']) }}

    @if ($errorBag->has('reference'))
        <div class="invalid-feedback">{{ $errorBag->first('reference') }}</div>
    @endif
</div>

<div class="mb-3 row{{ $errorBag->has('is_published') ? ' has-danger' : '' }}">
    <div class="col-md-10">
        {{ Form::hidden('is_published', 0) }}

        <div class="form-check form-switch">
            <label for="is_published" class="form-check-label" for="is_property_hidden">{{ __('Published') }}</label>
            {{ Form::checkbox('is_published', 1, null, ['class' => 'form-check-input', 'id' => 'is_published', 'role' => 'switch']) }}
        </div>

        @if ($errorBag->has('is_published'))
            <div class="invalid-feedback">{{ $errorBag->first('is_published') }}</div>
        @endif
    </div>
</div>
