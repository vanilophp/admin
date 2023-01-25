@extends('appshell::layouts.private')

@section('title')
    {{ __('Carriers') }}
@stop

@section('content')

    <div class="card card-accent-secondary">

        <div class="card-header">
            @yield('title')

            <div class="card-actionbar">
                @can('create carriers')
                    <a href="{{ route('vanilo.admin.carrier.create') }}" class="btn btn-sm btn-outline-success float-right">
                        {!! icon('+') !!}
                        {{ __('Create Carrier') }}
                    </a>
                @endcan
            </div>

        </div>

        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Enabled') }}</th>
                    <th style="width: 10%">&nbsp;</th>
                </tr>
                </thead>

                <tbody>
                @foreach($carriers as $carrier)
                    <tr>
                        <td>
                            <span class="font-lg mb-3 font-weight-bold">
                            @can('view carriers')
                                <a href="{{ route('vanilo.admin.carrier.show', $carrier) }}">{{ $carrier->name() }}</a>
                            @else
                                {{ $carrier->name() }}
                            @endcan
                            </span>
                        </td>
                        <td>
                            {!! icon($carrier->is_active ? 'active' : 'inactive') !!}
                        </td>
                        <td>
                            @can('edit carriers')
                                <a href="{{ route('vanilo.admin.carrier.edit', $carrier) }}"
                                   class="btn btn-xs btn-outline-primary btn-show-on-tr-hover float-right">{{ __('Edit') }}</a>
                            @endcan

                            @can('delete carriers')
                                {{ Form::open([
                                    'url' => route('vanilo.admin.carrier.destroy', $carrier),
                                    'data-confirmation-text' => __('Delete this carrier: ":name"?', ['name' => $carrier->name()]),
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
