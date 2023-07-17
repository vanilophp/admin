@can('delete orders')
    {!! Form::open(['route' => ['vanilo.admin.order.destroy', $order], 'method' => 'DELETE', 'class' => "d-inline"]) !!}
    <x-appshell::button variant="outline-danger" :title="__('Delete order')" icon="delete" size="sm" />
    {!! Form::close() !!}<span class="border-end border-secondary mx-2"></span>&nbsp;
@endcan

@can('view orders')
    <x-appshell::button variant="outline-secondary" :href="route('vanilo.admin.order.show', $order) . '?print=1'" size="sm">
        {{ __('Print') }}
    </x-appshell::button>
@endcan

@can('edit orders')
    <span class="dropdown">
        <a class="btn btn-sm btn-outline-info dropdown-toggle" href="#" data-bs-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false"
           id="account-dropdown-link">
            {{ __('Update status') }}
        </a>
        <div class="dropdown-menu">
            @foreach(enum('order_status')->choices() as $value => $label)
                <a class="dropdown-item" href="#"
                   @if ($order->status->value() == $value)
                       style="pointer-events: none; color: silver"
                   @else
                       onclick="event.preventDefault(); submitOrderUpdate('{{$value}}');"
                    @endif
                >{{ $label }}</a>
            @endforeach

            {!! Form::model($order, [
                'route'  => ['vanilo.admin.order.update', $order],
                'method' => 'PUT',
                'id'     => 'order-update-form',
                'style'  => 'display: none;'
            ]) !!}
            {{ Form::hidden('status', $order->status->value(), ['method' => 'PUT', 'id' => 'order_status_field']) }}

            {!! Form::close() !!}

        </div>

    </span>
    <script>
        function submitOrderUpdate(status) {
            document.getElementById('order_status_field').setAttribute('value', status);
            document.getElementById('order-update-form').submit();
        }
    </script>
@endcan
