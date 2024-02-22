<?php

declare(strict_types=1);

/**
 * Contains the CreateTaxCategory class.
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
use Vanilo\Admin\Contracts\Requests\CreateTaxCategory as CreateTaxCategoryContract;
use Vanilo\Taxes\Models\TaxCategoryTypeProxy;

class CreateTaxCategory extends FormRequest implements CreateTaxCategoryContract
{
    public function rules()
    {
        return [
            'name' => 'required|min:1|max:255',
            'type' => ['required', Rule::in(TaxCategoryTypeProxy::values())],
            'is_active' => 'sometimes|boolean',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
