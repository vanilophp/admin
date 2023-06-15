@extends('appshell::layouts.private')

@section('title')
    {{ __('Product Properties') }}
@stop

@push('page-actions')
    @can('create customers')
        <x-appshell::button variant="success" size="sm" icon="+" :href="route('vanilo.admin.property.create')">
            {{ __('New Property') }}
        </x-appshell::button>
    @endcan
@endpush

@section('content')
    <x-appshell::card accent="secondary">
        <x-slot:title>@yield('title')</x-slot:title>

        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Slug') }}</th>
                <th>{{ __('Type') }}</th>
                <th>{{ __('Created') }}</th>
                <th style="width: 10%">&nbsp;</th>
            </tr>
            </thead>

            <tbody>
            @foreach($properties as $property)
                <tr>
                    <td>
                            <span class="font-lg mb-3 font-weight-bold">
                            @can('view properties')
                                    <a href="{{ route('vanilo.admin.property.show', $property) }}">{{ $property->name }}</a>
                                @else
                                    {{ $property->name }}
                                @endcan
                            </span>
                    </td>
                    <td>{{ $property->slug }}</td>
                    <td>{{ $property->getType()->getName() }}</td>
                    <td><span title="{{ $property->created_at }}">{{ show_datetime($property->created_at) }}</span></td>
                    <td>
                        @can('edit properties')
                            <a href="{{ route('vanilo.admin.property.edit', $property) }}"
                               class="btn btn-xs btn-outline-primary btn-show-on-tr-hover float-right">{{ __('Edit') }}</a>
                        @endcan

                        @can('delete properties')
                            {{ Form::open([
                                'url' => route('vanilo.admin.property.destroy', $property),
                                'data-confirmation-text' => __('Delete this property: ":name"?', ['name' => $property->name]),
                                'method' => 'DELETE'
                            ])}}
                            <button class="btn btn-xs btn-outline-danger btn-show-on-tr-hover float-right">{{ __('Delete') }}</button>
                            {{ Form::close() }}
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </x-appshell::card>

    @if($properties->hasPages())
        <hr>
        <nav>
            {{ $properties->withQueryString()->links() }}
        </nav>
    @endif
@stop
