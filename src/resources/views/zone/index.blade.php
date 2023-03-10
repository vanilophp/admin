@extends('appshell::layouts.private')

@section('title')
    {{ __('Geographic Zones') }}
@stop

@section('content')
    <div class="card card-accent-secondary">

        <div class="card-header">
            @yield('title')

            <div class="card-actionbar">
                @can('create carriers')
                    <a href="{{ route('vanilo.admin.zone.create') }}" class="btn btn-sm btn-outline-success float-right">
                        {!! icon('+') !!}
                        {{ __('Create Zone') }}
                    </a>
                @endcan
            </div>

        </div>

        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Scope') }}</th>
                    <th style="width: 10%">&nbsp;</th>
                </tr>
                </thead>

                <tbody>
                @foreach($zones as $zone)
                    <tr>
                        <td>
                            <span class="font-lg mb-3 font-weight-bold">
                            @can('view zones')
                                <a href="{{ route('vanilo.admin.zone.show', $zone) }}">{{ $zone->name }}</a>
                            @else
                                {{ $zone->name }}
                            @endcan
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-pill badge-{{ enum_color($zone->scope) }}">{{ $zone->scope }}</span>
                        </td>
                        <td>
                            @can('edit zones')
                                <a href="{{ route('vanilo.admin.zone.edit', $zone) }}"
                                   class="btn btn-xs btn-outline-primary btn-show-on-tr-hover float-right">{{ __('Edit') }}</a>
                            @endcan

                            @can('delete zones')
                                {{ Form::open([
                                    'url' => route('vanilo.admin.zone.destroy', $zone),
                                    'data-confirmation-text' => __('Delete this zone: ":name"?', ['name' => $zone->name]),
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

        </div>
    </div>

@stop
