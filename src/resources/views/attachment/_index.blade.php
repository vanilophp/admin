@if(method_exists($model, 'getAttachments'))
<?php $attachments = $model->getAttachments() ?>

<x-appshell::card>
    <x-slot:title>
        {{ __('Attachments') }}
        <x-appshell::badge variant="secondary">{{ $attachments->count() }}</x-appshell::badge>
    </x-slot:title>

    @if($attachments->isNotEmpty())
        <ul class="list-unstyled mb-0">
        @foreach($attachments as $attachment)
            <li class="d-flex align-items-center mb-1">
                <span class="me-2 text-secondary">{!! icon('file') !!}</span>
                <a href="{{ $attachment->getUrl() }}" target="_blank" class="text-truncate" title="{{ $attachment->file_name }}">{{ $attachment->file_name }}</a>
                <span class="ms-auto ps-2 small text-secondary text-nowrap">{{ $attachment->human_readable_size }}</span>
            </li>
        @endforeach
        </ul>
    @else
        <x-appshell::alert variant="secondary">{{ __('No attachments') }}</x-appshell::alert>
    @endif
</x-appshell::card>
@endif
