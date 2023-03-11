@extends('appshell::layouts.private')

@section('title')
    {{ __('Add Area to the `:zone` :scope Zone', ['zone' => $zone->name, 'scope' => $zone->scope->label()]) }}
@stop

@section('content')
{!! Form::open(['url' => route('vanilo.admin.zone_member.store', $zone), 'autocomplete' => 'off', 'x-data' => 'vaniloZoneMember']) !!}

    <div class="card card-accent-success">

        <div class="card-header">
            {{ __('Area To Add') }}
        </div>

        <div class="card-body">
            @include('vanilo::zone-member._form')
        </div>

        <div class="card-footer">
            <button class="btn btn-success">{{ __('Add to the zone') }}</button>
            <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
        </div>
    </div>

{!! Form::close() !!}
@stop

@push('scripts')
    <script>
        document.addEventListener('alpine:init', function() {
            Alpine.data('vaniloZoneMember', () => ({
                memberType: '{{ $zoneMember->member_type->value() }}',
                adding: {
                    name: '',
                    property_id: ''
                },
            }))
        })
    </script>
@endpush
