@extends('appshell::layouts.private')

@section('title')
    {{ __('Category Trees') }}
@stop

@push('page-actions')
    @can('create customers')
        <x-appshell::button variant="success" size="sm" icon="+" :href="route('vanilo.admin.taxonomy.create')">
            {{ __('New Category Tree') }}
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
                <th>{{ __('Created') }}</th>
                <th style="width: 10%">&nbsp;</th>
            </tr>
            </thead>

            <tbody>
            @foreach($taxonomies as $taxonomy)
                <tr>
                    <td>
                        <span class="font-lg mb-3 font-weight-bold">
                        @can('view taxonomies')
                                <a href="{{ route('vanilo.admin.taxonomy.show', $taxonomy) }}">{{ $taxonomy->name }}</a>
                            @else
                                {{ $taxonomy->name }}
                            @endcan
                        </span>
                    </td>
                    <td>{{ $taxonomy->slug }}</td>
                    <td><span title="{{ $taxonomy->created_at }}">{{ show_datetime($taxonomy->created_at) }}</span></td>
                    <td>
                        @can('edit taxonomies')
                            <a href="{{ route('vanilo.admin.taxonomy.edit', $taxonomy) }}"
                               class="btn btn-xs btn-outline-primary btn-show-on-tr-hover float-right">{{ __('Edit') }}</a>
                        @endcan

                        @can('delete taxonomies')
                            {{ Form::open([
                                'url' => route('vanilo.admin.taxonomy.destroy', $taxonomy),
                                'data-confirmation-text' => __('Delete this categorization: ":name"?', ['name' => $taxonomy->name]),
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
@stop
