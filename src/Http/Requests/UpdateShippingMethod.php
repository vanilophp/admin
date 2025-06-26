<?php

declare(strict_types=1);

/**
 * Contains the UpdateShippingMethod class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-01-25
 *
 */

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Vanilo\Admin\Contracts\Requests\UpdateShippingMethod as UpdateShippingMethodContract;
use Vanilo\Shipment\Models\ShippingCategoryMatchingCondition;
use Vanilo\Shipment\Models\ShippingCategoryMatchingConditionProxy;
use Vanilo\Shipment\Models\TimeUnit;
use Vanilo\Shipment\ShippingFeeCalculators;

class UpdateShippingMethod extends FormRequest implements UpdateShippingMethodContract
{
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'carrier_id' => 'required|exists:carriers,id',
            'zone_id' => 'sometimes|nullable|exists:zones,id',
            'calculator' => ['sometimes', 'nullable', Rule::in(ShippingFeeCalculators::ids())],
            'configuration' => 'sometimes|json',
            'is_active' => 'sometimes|boolean',
            'eta_min' => 'sometimes|nullable|integer',
            'eta_max' => 'sometimes|nullable|integer',
            'eta_units' => ['sometimes', 'nullable', Rule::enum(TimeUnit::class)],
            'shipping_category_id' => 'sometimes|nullable|exists:shipping_categories,id',
            'shipping_category_matching_condition' => ['sometimes', 'nullable', Rule::in(ShippingCategoryMatchingConditionProxy::values())]
        ];
    }

    protected function prepareForValidation()
    {
        if (!$this->filled('shipping_category_id')) {
            $this->merge([
                'shipping_category_matching_condition' => null,
            ]);
        }
    }

    public function authorize()
    {
        return true;
    }
}
