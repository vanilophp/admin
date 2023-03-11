@foreach($zoneMembers as $member)

    @can('edit zones')
        <span class="dropdown" title="{{ $member->member_type->label() }}">
            <button @class(['btn dropdown-toggle', 'btn-secondary' => $member->isCountry(), 'btn-dark' => $member->isProvince()])
                    type="button" data-toggle="dropdown" aria-expanded="false">
                {{ $member->getName() }}
            </button>
            <div class="dropdown-menu">
                {{ Form::open([
                            'url' => route('vanilo.admin.zone_member.destroy', [$zone, $member]),
                            'style' => 'display: inline',
                            'data-confirmation-text' => __('Remove :name from the zone?', ['name' => $member->getName()]),
                            'method' => 'DELETE'
                        ])
                }}
                <button class="dropdown-item" type="submit">
                    {!! icon('delete', 'danger') !!}
                    {{ __('Delete ":name"', ['name' => $member->getName()]) }}
                </button>
                {{ Form::close() }}
            </div>
        </span>
    @else
        <button @class(['btn', 'btn-secondary' => $member->isCountry(), 'btn-dark' => $member->isProvince()])
                type="button" title="{{ $member->member_type->label() }}">
            {{ $member->getName() }}
        </button>
    @endcan
@endforeach
@can('create zones')
    <a href="{{ route('vanilo.admin.zone_member.create', $zone) }}" class="btn btn-success"
       title="{{ __('Add area') }}">{!! icon('+') !!}</a>
@endcan
