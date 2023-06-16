@extends('appshell::layouts.private')

@section('title')
    {{ __('Add Area to the `:zone` :scope Zone', ['zone' => $zone->name, 'scope' => $zone->scope->label()]) }}
@stop

@section('content')
{!! Form::open(['url' => route('vanilo.admin.zone_member.store', $zone), 'autocomplete' => 'off', 'x-data' => 'vaniloZoneMember']) !!}

    <x-appshell::card accent="success">

        <x-slot:title>{{ __('Area To Add') }}</x-slot:title>

        @include('vanilo::zone-member._form')

        <x-slot:footer>
            <x-appshell::create-button :text="__('Add to the zone')" />
            <x-appshell::cancel-button />
        </x-slot:footer>
    </x-appshell::card>

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
