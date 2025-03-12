<div id="create-video-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            {!! Form::open([
                    'url'  => route('vanilo.admin.video.store'),
                    'method' => 'POST'
                ])
            !!}

            <div class="modal-header">
                <h5 class="modal-title">{{ __('Add Video') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
            </div>

            <div class="modal-body">
                {{ Form::hidden('for', shorten(get_class($model))) }}
                {{ Form::hidden('forId', $model->id) }}

                @include('vanilo::video._form')
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">{{ __('Close') }}</button>
                <button class="btn btn-primary">{{ __('Save') }}</button>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>
