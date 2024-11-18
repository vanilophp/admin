<?php

declare(strict_types=1);
/**
 * Contains the UpdateOrder class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-12-17
 *
 */

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Vanilo\Admin\Contracts\Requests\UpdateOrder as UpdateOrderContract;
use Vanilo\Order\Contracts\Order;
use Vanilo\Order\Models\OrderStatusProxy;

class UpdateOrder extends FormRequest implements UpdateOrderContract
{
    public function rules(): array
    {
        return [
            'status' => ['sometimes', Rule::in(OrderStatusProxy::values())],
            'billpayer' => 'sometimes|array',
            'billpayer.email' => 'required_with:billpayer|email',
            'billpayer.phone' => 'sometimes|nullable|min:4|max:22',
            'billpayer.firstname' => 'required_with:billpayer|min:2|max:255',
            'billpayer.lastname' => 'required_with:billpayer|min:2|max:255',
            'billpayer.is_organization' => 'sometimes|boolean',
            'billpayer.company_name' => 'required_if:billpayer.is_organization,1|nullable|min:5',
            'billpayer.tax_nr' => 'sometimes|nullable|min:5',
            'billpayer.registration_nr' => 'sometimes|nullable|string|max:255',
            'billpayer.address.address' => 'required_with:billpayer|min:12|max:384',
            'billpayer.address.postalcode' => 'nullable|min:4|max:12',
            'billpayer.address.city' => 'nullable|min:2|max:255',
            'billpayer.address.country_id' => ['required_with:billpayer', 'alpha:ascii', 'size:2', 'exists:countries,id'],
        ];
    }

    public function wantsToChangeOrderStatus(Order $order): bool
    {
        $status = $this->getStatus();

        if (null === $status) {
            return false;
        }

        return $status !== $order->getStatus()->value();
    }

    public function wantsToUpdateBillpayerData(): bool
    {
        return !empty($this->input('billpayer'));
    }

    public function getStatus(): ?string
    {
        return $this->get('status');
    }

    public function authorize()
    {
        return true;
    }

    public function isOrganization(): bool
    {
        return $this->input('billpayer.is_organization') || !empty($this->input('company_name'));
    }

    public function messages(): array
    {
        return [
            'billpayer.company_name.required_if' => __('Enter the company name, or uncheck the `Organization` switch'),
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        session()->flash('updateBillpayerValidationError');

        throw new HttpResponseException(
            redirect()->back()->withErrors($validator)->withInput()
        );
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('billpayer') && !$this->isOrganization()) {
            $this->merge([
                'billpayer' => array_merge($this->input('billpayer', []), [
                    'company_name' => null,
                    'registration_nr' => null,
                    'tax_nr' => null,
                ]),
            ]);
        }
    }
}
