@extends('appshell::layouts.private')

@section('title')
    {{ $taxonomy->name }}
@stop

@push('page-actions')
    @can('delete taxonomies')
        {!! Form::open([
                'route' => ['vanilo.admin.taxonomy.destroy', $taxonomy],
                'method' => 'DELETE',
                'class' => 'd-inline',
                'data-confirmation-text' => __('Delete this categorization: ":name"?', ['name' => $taxonomy->name])
            ])
        !!}
        <x-appshell::button variant="outline-danger" type="submit">
            {{ __('Delete Category Tree') }}
        </x-appshell::button>
        {!! Form::close() !!}
    @endcan

    @can('edit taxonomies')
        <x-appshell::button variant="outline-primary" :href="route('vanilo.admin.taxonomy.edit', $taxonomy)">
            {{ __('Edit Category Tree') }}
        </x-appshell::button>
    @endcan
@endpush

@section('content')

    <style>
        .card-actionbar-show-on-hover {
            opacity: 0;
            transition: opacity 0.2s ease-in-out;
        }

        .card-body:hover > .card-actionbar-show-on-hover {
            opacity: 1;
        }
    </style>

<div class="row">
    <div class="col-12 col-md-6 col-lg-8 col-xl-9">
        <x-appshell::card>
            @include('vanilo::taxon._tree', ['taxons' => $taxonomy->rootLevelTaxons()])

        @can('create taxons')
            <x-slot:footer>
                <x-appshell::button :href="route('vanilo.admin.taxon.create', $taxonomy)" variant="outline-success" size="sm">{{ __('Add :category', ['category' => \Illuminate\Support\Str::singular($taxonomy->name)]) }}</x-appshell::button>
            </x-slot:footer>
        </x-appshell::card>
    @endcan
    </div>

    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
        @include('vanilo::media._index', ['model' => $taxonomy])
    </div>

</div>

@stop
