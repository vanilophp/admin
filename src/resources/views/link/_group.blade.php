@if($group->isUnidirectional())
    <h6>{{ __(':type items of :root', ['type' => $group->type->name, 'root' => $group->rootItem->linkable->name]) }}</h6>
    @foreach($group->items as $link)
        @unless($link->id === $group->root_item_id)
        <article class="d-inline-block border rounded me-1 mb-1 pe-1" title="{{ $link->linkable->name }}{{ $link->linkable->sku ? " [SKU: {$link->linkable->sku}]" : '' }}">
            <img src="{{ $link->linkable->getThumbnailUrl() }}" class="rounded-start" style="height: 2rem" />
            <span class="fw-semibold me-1">{{ Str::limit($link->linkable->name, 12) }}</span>
        </article>
        @endunless
    @endforeach
@else
    <h6>{{ __(':type items (omnidirectional group)', ['type' => $group->type->name]) }}</h6>
    @foreach($group->items as $link)
        <article class="d-inline-block border rounded me-1 mb-1 pe-1" title="{{ $link->linkable->name }}{{ $link->linkable->sku ? " [SKU: {$link->linkable->sku}]" : '' }}">
            <img src="{{ $link->linkable->getThumbnailUrl() }}" class="rounded-start" style="height: 2rem" />
            <span class="fw-semibold me-1">{{ Str::limit($link->linkable->name, 12) }}</span>
        </article>
    @endforeach
@endif
