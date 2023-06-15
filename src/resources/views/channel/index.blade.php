@extends('appshell::layouts.private')

@section('title')
    {{ __('Channels') }}
@stop

@push('page-actions')
    @can('create channels')
        <x-appshell::button size="sm" variant="success" icon="+" :href="route('vanilo.admin.channel.create')">
            {{ __('Create Channel') }}
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
            @foreach($channels as $channel)
                <tr>
                    <td>
                            <span class="font-lg mb-3 font-weight-bold">
                            @can('view channels')
                                    <a href="{{ route('vanilo.admin.channel.show', $channel) }}">{{ $channel->name }}</a>
                                @else
                                    {{ $channel->name }}
                                @endcan
                            </span>
                    </td>
                    <td>{{ $channel->slug }}</td>
                    <td><span title="{{ $channel->created_at }}">{{ show_datetime($channel->created_at) }}</span></td>
                    <td>
                        @can('edit channels')
                            <a href="{{ route('vanilo.admin.channel.edit', $channel) }}"
                               class="btn btn-xs btn-outline-primary btn-show-on-tr-hover float-right">{{ __('Edit') }}</a>
                        @endcan

                        @can('delete channels')
                            {{ Form::open([
                                'url' => route('vanilo.admin.channel.destroy', $channel),
                                'data-confirmation-text' => __('Delete this channel: ":name"?', ['name' => $channel->name]),
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

    @if($channels->hasPages())
        <hr>
        <nav>
            {{ $channels->withQueryString()->links() }}
        </nav>
    @endif

@stop
