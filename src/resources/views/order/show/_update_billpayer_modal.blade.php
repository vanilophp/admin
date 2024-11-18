<div id="update-billpayer-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="update-billpayer-modal-title" aria-hidden="true" x-data="editBillpayerModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            {!! Form::open([
                    'url'  => route('vanilo.admin.order.update', $order),
                    'method' => 'PUT'
                ])
            !!}

            <div class="modal-header">
                <h5 class="modal-title" id="properties-assign-to-model-modal">{{ __('Edit Billpayer') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
            </div>

            <div class="modal-body">
                @php
                    $billpayer = $order->billpayer;
                    $billpayerAddress = $billpayer->address;
                @endphp

                <div class="row">
                    <div class="col-md-6">
                        <label for="firstname" class="form-label">{{ __('First Name') }}</label>

                        <div class="mb-3">
                            {{ Form::text('billpayer[firstname]', old('billpayer.firstname', $billpayer->firstname), ['class' => 'form-control' . ($errors->has('billpayer.firstname') ? ' is-invalid' : ''), 'id' => 'firstname']) }}

                            @if ($errors->has('billpayer.firstname'))
                                <div class="invalid-feedback">{{ $errors->first('billpayer.firstname') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="lastname" class="form-label">{{ __('Last Name') }}</label>

                        <div class="mb-3">
                            {{ Form::text('billpayer[lastname]', old('billpayer.lastname', $billpayer->lastname), ['class' => 'form-control' . ($errors->has('billpayer.lastname') ? ' is-invalid' : ''), 'id' => 'lastname']) }}

                            @if ($errors->has('billpayer.lastname'))
                                <div class="invalid-feedback">{{ $errors->first('billpayer.lastname') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="email" class="form-label">{{ __('Email') }}</label>

                        <div class="mb-3">
                            {{ Form::email('billpayer[email]', old('billpayer.email', $billpayer->email), ['class' => 'form-control' . ($errors->has('billpayer.email') ? ' is-invalid' : ''), 'id' => 'email']) }}

                            @if ($errors->has('billpayer.email'))
                                <div class="invalid-feedback">{{ $errors->first('billpayer.email') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label">{{ __('Phone') }}</label>

                        <div class="mb-3">
                            {{ Form::text('billpayer[phone]', old('billpayer.phone', $billpayer->phone), ['class' => 'form-control' . ($errors->has('billpayer.phone') ? ' is-invalid' : ''), 'id' => 'phone']) }}

                            @if ($errors->has('billpayer.phone'))
                                <div class="invalid-feedback">{{ $errors->first('billpayer.phone') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <hr>

                <div class="mb-3 row{{ $errors->has('is_organization') ? ' has-danger' : '' }}">
                    <div class="col-md-6">
                        <div class="form-check form-switch">
                            {!! Form::checkbox(
                                    'billpayer[is_organization]', 1, null, [
                                    'class' => 'form-check-input',
                                    'id' => 'is_organization',
                                    'role' => 'switch',
                                    'x-model' => 'isOrganization',
                                ])
                            !!}
                            <label for="is_organization" class="form-check-label" for="is-shipping-method-active">{{ __('Organization') }}</label>
                        </div>

                        @if ($errors->has('billpayer.is_organization'))
                            <div class="invalid-feedback">{{ $errors->first('billpayer.is_organization') }}</div>
                        @endif
                    </div>
                </div>

                <div x-show="isOrganization" class="row">
                    <div class="col-md-6">
                        <label for="company_name" class="form-label">{{ __('Company Name') }}</label>

                        <div class="mb-3">
                            {{ Form::text('billpayer[company_name]', old('billpayer.company_name', $billpayer->company_name), ['class' => 'form-control' . ($errors->has('billpayer.company_name') ? ' is-invalid' : ''), 'id' => 'company_name']) }}

                            @if ($errors->has('billpayer.company_name'))
                                <div class="invalid-feedback">{{ $errors->first('billpayer.company_name') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="tax_nr" class="form-label">{{ __('Tax Number') }}</label>

                        <div class="mb-3">
                            {{ Form::text('billpayer[tax_nr]', old('billpayer.tax_nr', $billpayer->tax_nr), ['class' => 'form-control' . ($errors->has('billpayer.tax_nr') ? ' is-invalid' : ''), 'id' => 'tax_nr']) }}

                            @if ($errors->has('billpayer.tax_nr'))
                                <div class="invalid-feedback">{{ $errors->first('billpayer.tax_nr') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div x-show="isOrganization" class="row">
                    <div class="col-md-6">
                        <label for="registration_nr" class="form-label">{{ __('Registration number') }}</label>

                        <div class="mb-3">
                            {{ Form::text('billpayer[registration_nr]', old('billpayer.registration_nr', $billpayer->registration_nr), ['class' => 'form-control' . ($errors->has('billpayer.registration_nr') ? ' is-invalid' : ''), 'id' => 'registration_nr']) }}

                            @if ($errors->has('billpayer.registration_nr'))
                                <div class="invalid-feedback">{{ $errors->first('billpayer.registration_nr') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <label for="country_id" class="form-label">{{ __('Country') }}</label>

                        <div class="mb-3">
                            <select name="billpayer[address][country_id]" id="country_id" class="form-select {{ $errors->has('billpayer.address.country_id') ? ' is-invalid' : '' }}">
                                <template x-for="(name, id) in countries" :key="id">
                                    <option :value="id" x-text="name" :selected="'{{ old('billpayer.address.country_id', $billpayerAddress->country_id) }}' == id"></option>
                                </template>
                            </select>

                            @if ($errors->has('billpayer.address.country_id'))
                                <div class="invalid-feedback">{{ $errors->first('billpayer.address.country_id') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="postalcode" class="form-label">{{ __('Postal Code') }}</label>

                        <div class="mb-3">
                            {{ Form::text('billpayer[address][postalcode]', old('billpayer.address.postalcode', $billpayerAddress->postalcode), ['class' => 'form-control' . ($errors->has('billpayer.address.postalcode') ? ' is-invalid' : ''), 'id' => 'postalcode']) }}

                            @if ($errors->has('billpayer.address.postalcode'))
                                <div class="invalid-feedback">{{ $errors->first('billpayer.address.postalcode') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="city" class="form-label">{{ __('City') }}</label>

                        <div class="mb-3">
                            {{ Form::text('billpayer[address][city]', old('billpayer.address.city', $billpayerAddress->city), ['class' => 'form-control' . ($errors->has('billpayer.address.city') ? ' is-invalid' : ''), 'id' => 'city']) }}

                            @if ($errors->has('billpayer.address.city'))
                                <div class="invalid-feedback">{{ $errors->first('billpayer.address.city') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="address" class="form-label">{{ __('Address') }}</label>

                        <div class="mb-3">
                            {{ Form::text('billpayer[address][address]', old('billpayer.address.address', $billpayerAddress->address), ['class' => 'form-control' . ($errors->has('billpayer.address.address') ? ' is-invalid' : ''), 'id' => 'address']) }}

                            @if ($errors->has('billpayer.address.address'))
                                <div class="invalid-feedback">{{ $errors->first('billpayer.address.address') }}</div>
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
            Alpine.data('editBillpayerModal', () => ({
                isOrganization: @json(old('billpayer.is_organization') == '1' || !empty($billpayer->company_name)),
                countries: @json($countries),
        }))
        });
    </script>
@endpush
