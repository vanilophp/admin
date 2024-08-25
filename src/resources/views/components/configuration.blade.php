<vanilo-configuration class="mb-3 d-block" x-data="{{ $jsid }}ConfigData" id="{{ $jsid }}">
    <div class="row">
        <label class="col-form-label col-form-label-sm col-md-2">
            {{ $label }}
        </label>
        <div class="col-md-10">
            <div class="form-check form-switch form-switch-small" title="Field-based editing coming soon!">
                <label disabled class="form-check-label" for="{{ $jsid }}Raw">{{ __('Edit as JSON') }}</label>
                <input disabled type="checkbox" class="form-check-input" role="switch" x-model="raw" checked="1" id="{{ $jsid }}Raw" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="offset-md-2 col-md-10" x-show="!raw">
            @foreach($widgets as $widget)
                {!! $widget !!}
            @endforeach
        </div>
        <div class="offset-md-2 col-md-5" x-show="raw">
            <?php
                if (null === $textFieldValue = old($field)) {
                    $textFieldValue = json_encode(match($modelIsBeingCreated) {
                        true => $model->hasConfiguration() ? $model->configuration() : ($sample ?? []),
                        false => $model->hasConfiguration() ? $model->configuration() : []
                    }, JSON_FORCE_OBJECT|JSON_PRETTY_PRINT);
                }
            ?>
            <textarea name="{{ $field }}"
                      class="form-control form-control-sm{{ $errors->has($field) ? ' is-invalid' : '' }}"
                      placeholder="{{ $placeholder }}"
                      rows="6"
            >{{ $textFieldValue }}</textarea>
            @if ($errors->has($field))
                <div class="invalid-feedback">{{ $errors->first($field) }}</div>
            @endif
        </div>
        <div class="col-md-5" x-show="raw" id="{{ $jsid }}Sample" x-on:config-sample-refresh="refreshConfigSample($event)" x-ref="sample">
            @fragment('configuration-sample')
            <h6>{{ __('Configuration Sample') }}</h6>
            <small><pre>{{ $sampleAsJson }}</pre></small>
            @endfragment
        </div>
    </div>
</vanilo-configuration>
@push('scripts')
    <script>
        document.addEventListener('alpine:init', function() {
            Alpine.data('{{ $jsid }}ConfigData', () => ({
                raw: true,
                refreshConfigSample(event) {
                    let url = `{{ $sampleRefreshRoute }}?_fragment=configuration-sample&{{ $passOnReload }}=${event.detail.type}`
                    axios.get(url)
                        .then((response) => {
                            this.$refs.sample.innerHTML = response.data
                        })
                        .catch((error) => {
                            console.error(error)
                        });
                },
            }))
        })
    </script>
@endpush
@if($reloadOnChangeOf)
    @push('scripts')
        <script>
            document.getElementById('{{ $reloadOnChangeOf }}').addEventListener('change', function () {
                document
                    .getElementById('{{ $jsid }}Sample')
                    .dispatchEvent(
                        new CustomEvent('config-sample-refresh', {detail: {type: document.getElementById('{{ $reloadOnChangeOf }}').value}})
                    )
            })
        </script>
    @endpush
@endif
