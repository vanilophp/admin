@if(method_exists($model, 'getAttachments'))
<?php $attachments = $model->getAttachments() ?>

<x-appshell::card accent="secondary">
    <x-slot:title>
        {{ __('Attachments') }}
        <x-appshell::badge variant="secondary">{{ $attachments->count() }}</x-appshell::badge>
    </x-slot:title>

    @error('attachments')
    <x-appshell::alert variant="danger">{{ $message }}</x-appshell::alert>
    @enderror
    @foreach($attachments as $attachment)
        <div class="card mb-2">
            <div class="card-body p-0 d-flex align-items-center">
                <div class="p-3 text-bg-secondary rounded-start">
                    <div class="align-content-center text-center">
                        {!! icon('file') !!}
                    </div>
                </div>
                <div class="flex-grow-1 text-truncate">
                    <div class="text-sm-left text-info fw-bold ps-2 text-truncate" title="{{ $attachment->file_name }}">
                        {{ $attachment->file_name }}
                    </div>
                    <div class="small text-secondary ps-2">
                        {{ $attachment->human_readable_size }}
                        &nbsp;
                        <a href="{{ $attachment->getUrl() }}" title="{{ $attachment->getUrl() }}" class="small text-secondary"
                           target="_blank">{!! icon('link') !!}</a>
                    </div>
                </div>
                <div class="pe-2 ps-2">
                    @can('delete media')
                        {!! Form::open([
                                'route' => ['vanilo.admin.attachment.destroy', $attachment],
                                'method' => 'DELETE',
                                'class' => "d-inline",
                                'data-confirmation-text' => __('Delete this attachment: ":name"?', ['name' => $attachment->file_name])
                            ])
                        !!}
                        <button class="btn btn-sm btn-outline-danger" title="{{ __('Delete attachment') }}">
                            {!! icon('delete') !!}
                        </button>
                        {!! Form::close() !!}
                    @endcan
                </div>
            </div>
        </div>
    @endforeach

    @can('create media')
        <h6 class="mt-4">
            @if($attachments->isNotEmpty())
                {{ __('Add Further Attachments') }}
            @else
                {{ __('Add Attachments') }}
            @endif
        </h6>

        <form action="{{ route('vanilo.admin.attachment.store') }}" enctype="multipart/form-data" method="post" class="input-group mb-4">
            {{ Form::file('attachments[]', ['multiple', 'class' => 'form-control']) }}
            @csrf
            {{ Form::hidden('for', shorten(get_class($model))) }}
            {{ Form::hidden('forId', $model->id) }}

            <x-appshell::button class="btn btn-sm btn-success" icon="upload" title="{{ __('Upload attachment(s)') }}">
            </x-appshell::button>
        </form>
        @if ($errors->has('attachments.*'))
            <x-appshell::alert variant="danger" class="my-2">
                @foreach($errors->get('attachments.*') as $fileErrors)
                    @foreach($fileErrors as $error)
                        {{ $error }}<br>
                    @endforeach
                @endforeach
            </x-appshell::alert>
        @endif
    @endcan
</x-appshell::card>
@endif
