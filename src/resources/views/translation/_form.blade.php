<div x-data="translationForm">
    <div class="btn-group my-3" role="group" aria-label="View of the Form">
        <input type="radio" class="btn-check" name="_view" id="viewSingle" value="single" autocomplete="off"
               x-model="view">
        <label class="btn btn-outline-primary" for="viewSingle">Single</label>

        <input type="radio" class="btn-check" name="_view" id="viewSideBySide" value="sidebyside" autocomplete="off"
               x-model="view">
        <label class="btn btn-outline-primary" for="viewSideBySide">Side by Side</label>
    </div>

    <hr>

    <div class="row">
        <div :class="'single' === view ? 'col' : 'col col-md-6'">
            <div class="mb-3">
                <x-appshell::floating-label :label="__('Name')" :is-invalid="$errors->has('name')">
                    {{ Form::text('name', null, [
                            'class' => 'form-control form-control-lg' . ($errors->has('name') ? ' is-invalid' : ''),
                            'placeholder' => __('Name')
                        ])
                    }}
                </x-appshell::floating-label>
                @if ($errors->has('name'))
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                @endif
            </div>

            @if($schema->usesSlug)
                <div class="mb-3 row">
                    <label class="col-form-label col-form-label-sm col-md-2">{{ __('Slug') }}</label>
                    <div class="col-md-10">
                        {{ Form::text('slug', null, [
                                'class' => 'form-control form-control-sm' . ($errors->has('slug') ? ' is-invalid': ''),
                                'placeholder' => __('URL fraction')
                            ])
                        }}
                        @if ($errors->has('slug'))
                            <div class="invalid-feedback">{{ $errors->first('slug') }}</div>
                        @endif
                    </div>
                </div>
            @endif

            @if($schema->hasAdditionalFields)
                <hr>
            @endif
        </div>
        <div class="col col-md-6" x-show="'sidebyside' === view">
            <div class="mb-3">
                <x-appshell::floating-label :label="__('Name')">
                    {{ Form::text('__name', $translatable->name, [
                            'class' => 'form-control form-control-lg form-control-plaintext',
                            'readonly' => true,
                            'placeholder' => __('Name')
                        ])
                    }}
                </x-appshell::floating-label>
            </div>

            @if($schema->usesSlug)
                <div class="mb-3 row">
                    <label class="col-form-label col-form-label-sm col-md-2">{{ __('Slug') }}</label>
                    <div class="col-md-10">
                        {{ Form::text('__slug', $translatable->slug, [
                                'class' => 'form-control form-control-sm form-control-plaintext',
                                'readonly' => true,
                                'placeholder' => __('URL fraction')
                            ])
                        }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', function () {
            Alpine.data('translationForm', () => ({
                view: 'single',
                addSelectedPropertyValue() {
                    if (this.selected && '' !== this.selected) {
                        var property = this.unassignedProperties[this.selected];
                        if (property) {
                            this.assignedProperties[property.property.id] = property;
                            delete this.unassignedProperties[property.property.id];
                        }
                    }
                }
            }))
        })
    </script>
@endpush
