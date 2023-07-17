@foreach($taxons as $taxon)
    <div class="card-body">

        @if ($taxon->children->isNotEmpty())
            <a href="#taxon-{{$taxon->id}}" aria-expanded="false"
               aria-controls="taxon-{{$taxon->id}}" data-bs-toggle="collapse"
               class="collapse-toggler-heading">
                &nbsp;{!! icon('>') !!}
            </a>
        @else
            &nbsp;{!! icon('>', 'light') !!}
        @endif

        @can('edit taxons')
            <a href="{{ route('vanilo.admin.taxon.edit', [$taxonomy, $taxon]) }}">{{ $taxon->name }}</a>
        @else
            {{ $taxon->name }}
        @endcan
        &nbsp;<x-appshell::badge variant="light" class="small">{{ $taxon->products()->count() }}</x-appshell::badge>

        <div class="d-inline card-actionbar-show-on-hover">
            @can('create taxons')
                <x-appshell::button
                    :href="route('vanilo.admin.taxon.create', $taxonomy).'?parent='.$taxon->id"
                    :title="__('Add Child :category', ['category' => \Illuminate\Support\Str::singular($taxonomy->name)])"
                    variant="outline-success"
                    size="xs"
                    icon="+"
                ></x-appshell::button>
            @endcan
            @can('delete taxons')
                {{ Form::open([
                            'url' => route('vanilo.admin.taxon.destroy', [$taxonomy, $taxon]),
                            'class' => 'form d-inline-flex',
                            'data-confirmation-text' => __('Delete :name?', ['name' => $taxon->name]),
                            'method' => 'DELETE'
                        ])
                }}
                    <x-appshell::button :title="__('Delete')" variant="outline-danger" size="xs" icon="delete"></x-appshell::button>
                {{ Form::close() }}
            @endcan
        </div>
    </div>

    @if ($taxon->children->isNotEmpty())
        <div id="taxon-{{$taxon->id}}" data-bs-toggle="collapse">
            <div class="card-body">
                <div class="card">
                    @include('vanilo::taxon._tree', ['taxons' => $taxon->children])
                </div>
            </div>
        </div>
    @endif

@endforeach
