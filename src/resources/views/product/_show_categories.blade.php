<x-appshell::card>
    <x-slot:title>{{ __('Categorization') }}</x-slot:title>

    <table class="table table-sm">
        @foreach($taxonomies as $taxonomy)
            <tr>
                <td>{{ $taxonomy->name }}</td>
                <td>
                    @foreach($for->taxons()->byTaxonomy($taxonomy)->get() as $taxon)
                        <x-appshell::badge variant="dark">{{ $taxon->name }}</x-appshell::badge>
                    @endforeach
                </td>
                <td class="text-end">
                    <x-appshell::button data-bs-toggle="modal" data-bs-target="#taxon-assign-to-model-{{$taxonomy->id}}"
                        size="xs" variant="outline-success" class="mb-2">
                        {{ __('Manage') }}
                    </x-appshell::button>
                </td>
            </tr>
        @endforeach
    </table>
</x-appshell::card>

@foreach($taxonomies as $taxonomy)
    @include('vanilo::taxon.assign._form', [
        'for' => shorten(get_class($for)),
        'forId' => $for->id,
        'assignments' => $for->taxons()->byTaxonomy($taxonomy)->get()->keyBy('id'),
        'taxonomy' => $taxonomy
        ])
@endforeach
