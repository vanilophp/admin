<?php

declare(strict_types=1);

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Vanilo\Admin\Contracts\Requests\UpdateShippingCategory as UpdateShippingCategoryContract;

class UpdateShippingCategory extends FormRequest implements UpdateShippingCategoryContract
{
    public function rules()
    {
        return [
            'name' => 'required|min:1|max:255',
            'is_fragile' => 'sometimes|boolean',
            'is_hazardous' => 'sometimes|boolean',
            'is_stackable' => 'sometimes|boolean',
            'requires_temperature_control' => 'sometimes|boolean',
            'requires_signature' => 'sometimes|boolean',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
