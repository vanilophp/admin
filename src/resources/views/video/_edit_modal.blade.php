@php
    $errorBag = 'updateVideo' . $video->hash;
@endphp

<div id="edit-video-modal-{{ $video->hash }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            {!! Form::model($video, [
                    'route'  => ['vanilo.admin.video.update', $video],
                    'method' => 'PUT',
                    'id' => 'edit-video-form' . $video->hash
                ])
            !!}

            <div class="modal-header">
                <h5 class="modal-title">{{ __('Edit Video') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
            </div>

            <div class="modal-body">
                @include('vanilo::video._form', ['errorBag' => $errors->$errorBag])
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">{{ __('Close') }}</button>
                <button class="btn btn-primary">{{ __('Update') }}</button>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>

@if($errors->$errorBag->any())
    <script>
      document.addEventListener('DOMContentLoaded', function () {
          new bootstrap.Modal('#edit-video-modal-{{ $video->hash }}').show();
      });
    </script>
@endif
