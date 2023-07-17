@foreach($propertyValues as $propertyValue)

    @canany(['edit property values', 'delete property values'])
        <span class="dropdown" title="{{ $propertyValue->title }}">
            <x-appshell::button size="sm" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" variant="secondary">
                {{ $propertyValue->title }}
            </x-appshell::button>
            <div class="dropdown-menu">
                @can('edit property values')
                    <a href="{{ route('vanilo.admin.property_value.edit', [$property, $propertyValue]) }}" class="dropdown-item">{{ __('Edit') }}</a>
                @endcan
                @can('delete property values')
                {{ Form::open([
                    'url' => route('vanilo.admin.property_value.destroy', [$property, $propertyValue]),
                    'style' => 'display: inline',
                    'data-confirmation-text' => __('Delete :title?', ['title' => $propertyValue->title]),
                    'method' => 'DELETE'
                ]) }}
                <button class="dropdown-item" type="submit">
                    {!! icon('delete', 'danger') !!}
                    {{ __('Delete ":name"', ['name' => $propertyValue->title]) }}
                </button>
                {{ Form::close() }}
                @endcan
            </div>
        </span>
    @else
        <x-appshell::button variant="secondary">{{ $propertyValues->title }}</x-appshell::button>
    @endcanany
@endforeach

@can('create property values')
    <x-appshell::button :href="route('vanilo.admin.property_value.create', $property)"
        :title="__('Add :property value', ['property' => $property->name])"
        size="sm" variant="success" icon="+"></x-appshell::button>
@endcan
