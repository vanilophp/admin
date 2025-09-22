<?php

declare(strict_types=1);

/**
 * Contains the UpdateMasterProduct class.
 *
 * @copyright   Copyright (c) 2023 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-01-06
 *
 */

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Vanilo\Admin\Contracts\Requests\UpdateMasterProduct as UpdateMasterProductContract;
use Vanilo\Product\Models\ProductStateProxy;

class UpdateMasterProduct extends FormRequest implements UpdateMasterProductContract
{
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'state' => ['required', Rule::in(ProductStateProxy::values())],
            'tax_category_id' => 'sometimes|nullable|exists:tax_categories,id',
            'shipping_category_id' => 'sometimes|nullable|exists:shipping_categories,id',
            'price' => 'nullable|numeric',
            'original_price' => 'nullable|numeric',
            'description' => 'nullable|string',
            'priority' => 'sometimes|integer',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpg,jpeg,pjpg,png,gif,webp'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
