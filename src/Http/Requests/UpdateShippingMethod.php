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
use Vanilo\Admin\Contracts\Requests\UpdateShippingMethod as UpdateShippingMethodContract;

class UpdateShippingMethod extends FormRequest implements UpdateShippingMethodContract
{
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'carrier_id' => 'required|exists:carriers,id',
            'configuration' => 'sometimes|json',
            'is_active' => 'sometimes|boolean',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
