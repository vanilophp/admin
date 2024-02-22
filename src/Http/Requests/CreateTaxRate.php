<?php

declare(strict_types=1);

/**
 * Contains the CreateTaxRate class.
 *
 * @copyright   Copyright (c) 2024 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2024-02-22
 *
 */

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Vanilo\Admin\Contracts\Requests\CreateTaxRate as CreateTaxRateContract;
use Vanilo\Taxes\TaxCalculators;

class CreateTaxRate extends FormRequest implements CreateTaxRateContract
{
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'tax_category_id' => 'sometimes|nullable|exists:tax_categories,id',
            'zone_id' => 'sometimes|nullable|exists:zones,id',
            'calculator' => ['sometimes', 'nullable', Rule::in(TaxCalculators::ids())],
            'configuration' => 'sometimes|json',
            'is_active' => 'sometimes|boolean',
            'rate' => 'required|numeric|min:0',
            'valid_from' => 'sometimes|nullable|date',
            'valid_until' => 'sometimes|nullable|date',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
