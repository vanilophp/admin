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
    public function rules(): array
    {
        return [
            'name' => 'required|min:1|max:255',
            'state' => ['required', 'max:255', Rule::in(ProductStateProxy::values())],
            'tax_category_id' => 'sometimes|nullable|integer|exists:tax_categories,id',
            'shipping_category_id' => 'sometimes|nullable|integer|exists:shipping_categories,id',
            'price' => 'nullable|numeric',
            'original_price' => 'nullable|numeric',
            'description' => 'nullable|string',
            'priority' => 'sometimes|integer',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpg,jpeg,pjpg,png,gif,webp',
            'channels' => 'sometimes|array',
            'excerpt' => 'sometimes|nullable|string|max:16383',
            'ext_title' => 'sometimes|nullable|string|max:511',
            'subtitle' => 'sometimes|nullable|string|max:255',
            'slug' => 'sometimes|nullable|string|max:255',
            'meta_keywords' => 'sometimes|nullable|string|max:2047',
            'meta_description' => 'sometimes|nullable|string|max:4095',
            'weight' => 'sometimes|nullable|numeric',
            'height' => 'sometimes|nullable|numeric',
            'width' => 'sometimes|nullable|numeric',
            'length' => 'sometimes|nullable|numeric',
            'custom_attributes' => 'sometimes|nullable|array',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
