<x-appshell::card>
    <x-slot:title>{{ __('Properties') }}</x-slot:title>

    <table class="table table-sm">
        <tr>
            <td>
                @foreach($for->propertyValues as $propertyValue)
                    <x-appshell::badge variant="dark">
                        {{ $propertyValue->property->name }}: {{ $propertyValue->title }}
                    </x-appshell::badge>
                @endforeach
            </td>
            <td class="text-end">
                <x-appshell::button data-bs-toggle="modal" data-bs-target="#properties-assign-to-model-modal"
                    size="xs" variant="outline-success" class="mb-2">
                    {{ __('Manage') }}
                </x-appshell::button>
            </td>
        </tr>
    </table>
</x-appshell::card>

@if ($errors->any())
    @php
        $hasPropertyValuesError = false;
        $propertyValuesErrorMessage = null;

        foreach ($errors->keys() as $key) {
            if (Str::startsWith($key, 'propertyValues')) {
                $hasPropertyValuesError = true;
                $propertyValuesErrorMessage = $errors->first($key);
                break;
            }
        }
    @endphp

    @if($hasPropertyValuesError)
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                new bootstrap.Modal('#properties-assign-to-model-modal').show();
            });
        </script>
    @endif
@endif

@include('vanilo::property-value.assign._form', [
    'for' => shorten(get_class($for)),
    'forId' => $for->id,
    'assignments' => $for->propertyValues,
    'properties' => $properties,
    'hasPropertyValuesError' => $hasPropertyValuesError ?? null,
    'propertyValuesErrorMessage' => $propertyValuesErrorMessage ?? null,
])
