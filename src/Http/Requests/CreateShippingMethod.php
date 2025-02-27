<?php

declare(strict_types=1);

/**
 * Contains the CreateShippingMethod class.
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
use Vanilo\Admin\Contracts\Requests\CreateShippingMethod as CreateShippingMethodContract;
use Vanilo\Shipment\Models\TimeUnit;
use Vanilo\Shipment\ShippingFeeCalculators;

class CreateShippingMethod extends FormRequest implements CreateShippingMethodContract
{
    use HasChannels;

    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'carrier_id' => 'required|exists:carriers,id',
            'zone_id' => 'sometimes|nullable|exists:zones,id',
            'calculator' => ['sometimes', 'nullable', Rule::in(ShippingFeeCalculators::ids())],
            'configuration' => 'sometimes|json',
            'is_active' => 'sometimes|boolean',
            'channels' => 'sometimes|array',
            'eta_min' => 'sometimes|nullable|integer',
            'eta_max' => 'sometimes|nullable|integer',
            'eta_units' => ['sometimes', 'nullable', Rule::enum(TimeUnit::class)],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
