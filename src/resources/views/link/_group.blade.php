@if($group->isUnidirectional())
    <h6>{{ __(':type items of :root', ['type' => $group->type->name, 'root' => $group->rootItem->linkable->name]) }}</h6>
    @foreach($group->items as $link)
        @unless($link->id === $group->root_item_id)
            @if(null !== $link->linkable)
            <a class="d-inline-block border rounded me-1 mb-1 pe-1"
               title="{{ $link->linkable->name }}{{ $link->linkable->sku ? " [SKU: {$link->linkable->sku}]" : '' }}"
               href="{{ admin_link_to($link->linkable) }}"
            >
                <img src="{{ $link->linkable->getThumbnailUrl() }}" class="rounded-start" style="height: 2rem" />
                <span class="fw-semibold me-1">{{ Str::limit($link->linkable->name, 12) }}</span>
            </a>
            @else
                <a class="d-inline-block border rounded me-1 mb-1 pe-1" href="#">
                    <img src="data:;base64,iVBORw0KGgoAAAANSUhEUgAAAPoAAAD6AQMAAACyIsh+AAAAA1BMVEWSj4+Y8UtxAAAAHklEQVRo3u3BAQEAAACCoP6vbojAAAAAAAAAAICwAyA6AAFG0xi/AAAAAElFTkSuQmCC" style="height: 2rem" />
                    <span class="fw-semibold me-1">{{ __('Deleted Entry (:type [:id])', ['type' => $link->linkable_type, 'id' => $link->linkable_id]) }}</span>
                </a>
            @endif
        @endunless
    @endforeach
@else
    <h6>{{ __(':type items (omnidirectional group)', ['type' => $group->type->name]) }}</h6>
    @foreach($group->items as $link)
        @if(null !== $link->linkable)
            <a class="d-inline-block border rounded me-1 mb-1 pe-1"
               title="{{ $link->linkable->name }}{{ $link->linkable->sku ? " [SKU: {$link->linkable->sku}]" : '' }}"
               href="{{ admin_link_to($link->linkable) }}"
            >
                <img src="{{ $link->linkable->getThumbnailUrl() }}" class="rounded-start" style="height: 2rem" />
                <span class="fw-semibold me-1">{{ Str::limit($link->linkable->name, 12) }}</span>
            </a>
        @else
            <a class="d-inline-block border rounded me-1 mb-1 pe-1" href="#">
                <img src="data:;base64,iVBORw0KGgoAAAANSUhEUgAAAPoAAAD6AQMAAACyIsh+AAAAA1BMVEWSj4+Y8UtxAAAAHklEQVRo3u3BAQEAAACCoP6vbojAAAAAAAAAAICwAyA6AAFG0xi/AAAAAElFTkSuQmCC" style="height: 2rem" />
                <span class="fw-semibold me-1">{{ __('Deleted Entry (:type [:id])', ['type' => $link->linkable_type, 'id' => $link->linkable_id]) }}</span>
            </a>
        @endif
    @endforeach
@endif
