<div id="update-shipping-address-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="update-shipping-address-modal-title" aria-hidden="true" x-data="updateShippingAddressModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            {!! Form::open([
                    'url'  => route('vanilo.admin.order.update', $order),
                    'method' => 'PUT'
                ])
            !!}

            <div class="modal-header">
                <h5 class="modal-title" id="properties-assign-to-model-modal">{{ __('Edit Shipping Address') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
            </div>

            <div class="modal-body">
                @php
                    $shippingAddress = $order->shippingAddress;
                @endphp

                <div class="row">
                    <div class="col-md-6">
                        <label for="name" class="form-label">{{ __('Name') }}</label>

                        <div class="mb-3">
                            {{ Form::text('shippingAddress[name]', old('shippingAddress.name', $shippingAddress->name), ['class' => 'form-control' . ($errors->has('shippingAddress.name') ? ' is-invalid' : ''), 'id' => 'name']) }}

                            @if ($errors->has('shippingAddress.name'))
                                <div class="invalid-feedback">{{ $errors->first('shippingAddress.name') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="shipping-country_id" class="form-label">{{ __('Country') }}</label>

                        <div class="mb-3">
                            <select name="shippingAddress[country_id]" id="shipping-country_id" class="form-select {{ $errors->has('shippingAddress.country_id') ? ' is-invalid' : '' }}">
                                <template x-for="(name, id) in countries" :key="id">
                                    <option :value="id" x-text="name" :selected="'{{ old('shippingAddress.country_id', $shippingAddress->country_id) }}' == id"></option>
                                </template>
                            </select>

                            @if ($errors->has('shippingAddress.country_id'))
                                <div class="invalid-feedback">{{ $errors->first('shippingAddress.country_id') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="shipping-postalcode" class="form-label">{{ __('Postal Code') }}</label>

                        <div class="mb-3">
                            {{ Form::text('shippingAddress[postalcode]', old('shippingAddress.postalcode', $shippingAddress->postalcode), ['class' => 'form-control' . ($errors->has('shippingAddress.postalcode') ? ' is-invalid' : ''), 'id' => 'shipping-postalcode']) }}

                            @if ($errors->has('shippingAddress.postalcode'))
                                <div class="invalid-feedback">{{ $errors->first('shippingAddress.postalcode') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="shipping-city" class="form-label">{{ __('City') }}</label>

                        <div class="mb-3">
                            {{ Form::text('shippingAddress[city]', old('shippingAddress.city', $shippingAddress->city), ['class' => 'form-control' . ($errors->has('shippingAddress.city') ? ' is-invalid' : ''), 'id' => 'shipping-city']) }}

                            @if ($errors->has('shippingAddress.city'))
                                <div class="invalid-feedback">{{ $errors->first('shippingAddress.city') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="shipping-address" class="form-label">{{ __('Address') }}</label>

                        <div class="mb-3">
                            {{ Form::text('shippingAddress[address]', old('shippingAddress.address', $shippingAddress->address), ['class' => 'form-control' . ($errors->has('shippingAddress.address') ? ' is-invalid' : ''), 'id' => 'shipping-address']) }}

                            @if ($errors->has('shippingAddress.address'))
                                <div class="invalid-feedback">{{ $errors->first('shippingAddress.address') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">{{ __('Close') }}</button>
                <button class="btn btn-primary">{{ __('Save') }}</button>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('updateShippingAddressModal', () => ({
                countries: @json($countries),
            }))
        });
    </script>
@endpush
