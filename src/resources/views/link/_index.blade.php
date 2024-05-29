<x-appshell::card>
    <x-slot:title>{{ __('Links') }}    </x-slot:title>

    @foreach($linkTypes as $linkTypeSlug => $linkTypeTitle)
        <div>
            <?php $links = link_items($linkTypeSlug)->of($model); ?>
            @unless($links->isEmpty())
                <h6>{{ $linkTypeTitle }}</h6>
                @foreach($links as $link)
                    <article class="d-inline-block border rounded me-1 mb-1 px-1" title="{{ $link->linkable->sku ?? '' }}">
                        <img src="{{ $link->linkable->getThumbnailUrl() }}" class="rounded-start" style="height: 2rem" />
                        <span class="fw-semibold me-1">{{ $link->linkable->name }}</span>
                        {!! Form::open(['route' => ['vanilo.admin.link.destroy', $link->id], 'method' => 'delete', 'class' => 'd-inline']) !!}
                        <button type="submit" class="btn btn-xs btn-link" title="{{ __('Delete the link') }}" >{!! icon('delete', 'danger') !!}</button>
                        {!! Form::close() !!}
                    </article>
                @endforeach
            @endunless
        </div>
    @endforeach

    <div class="my-2">
        <x-appshell::button variant="success" href="{{ route('vanilo.admin.link.create', ['source_id' => $model->id, 'source_type' => shorten($model::class)]) }}">{{ __('Link to...') }}</x-appshell::button>
    </div>

</x-appshell::card>
