<x-appshell::card>
    <x-slot:title>{{ __('Links') }}    </x-slot:title>

    @foreach($linkTypes as $linkTypeSlug => $linkTypeTitle)
        <div>
            <?php $groups = link_groups($linkTypeSlug)->of($model); ?>
            @unless($groups->isEmpty())
                @foreach($groups as $group)
                    @unless($group->isEmpty())
                    <h6>{{ $linkTypeTitle }}
                        @if($group->isUnidirectional())
                            {{ __('of :link_group_root', ['link_group_root' => $group->rootItem->linkable->name]) }}
                            {!! icon('unidirectional', 'muted', ['title' => __('Unidirectional')]) !!}
                        @else
                            {!! icon('omnidirectional', 'muted', ['title' => __('Omnidirectional')]) !!}
                        @endif
                    </h6>
                    @foreach($group->items as $link)
                        @unless($link->pointsTo($model))
                        <article class="d-inline-block border rounded me-1 mb-1 pe-1" title="{{ $link->linkable->name }}{{ $link->linkable->sku ? " [SKU: {$link->linkable->sku}]" : '' }}">
                            <a href="{{ admin_link_to($link->linkable) }}">
                                <img src="{{ $link->linkable->getThumbnailUrl() }}" class="rounded-start" style="height: 2rem" />
                                <span class="fw-semibold me-1">{{ Str::limit($link->linkable->name, 12) }}</span>
                            </a>
                            {!! Form::open(['route' => ['vanilo.admin.link.destroy', $link->id], 'method' => 'delete', 'class' => 'd-inline']) !!}
                            <button type="submit" class="btn btn-xs btn-link" title="{{ __('Delete the link') }}" >{!! icon('delete', 'danger') !!}</button>
                            {!! Form::close() !!}
                        </article>
                        @endunless
                    @endforeach
                    <x-appshell::button :title="__('Add another item to this link group')" variant="success"
                        href="{{ route('vanilo.admin.link.create', ['link_group_id' => $group->id]) }}"
                        size="xs">+</x-appshell::button>
                    <hr>
                    @endunless
                @endforeach
            @endunless
        </div>
    @endforeach

    <div class="my-2">
        <hr>
        <x-appshell::button variant="success" href="{{ route('vanilo.admin.link.create', ['source_id' => $model->id, 'source_type' => shorten($model::class)]) }}">{{ __('Link to...') }}</x-appshell::button>
    </div>

</x-appshell::card>
