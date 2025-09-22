<?php

declare(strict_types=1);

/**
 * Contains the UpdateMasterProductVariant class.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-12-20
 *
 */

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Vanilo\Admin\Contracts\Requests\UpdateMasterProductVariant as UpdateMasterProductVariantContract;
use Vanilo\Product\Models\ProductStateProxy;
use Vanilo\Support\Validation\Rules\MustBeAValidGtin;

class UpdateMasterProductVariant extends FormRequest implements UpdateMasterProductVariantContract
{
    public function rules()
    {
        return [
            'name' => 'required|min:1|max:255',
            'sku' => 'required|unique:products',
            'price' => 'nullable|numeric',
            'original_price' => 'sometimes|nullable|numeric',
            'shipping_category_id' => 'sometimes|nullable|exists:shipping_categories,id',
            'stock' => 'nullable|numeric',
            'backorder' => 'nullable|numeric|min:0',
            'excerpt' => 'sometimes|nullable|max:8192',
            'description' => 'sometimes|nullable|max:32768',
            'priority' => 'sometimes|integer',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpg,jpeg,pjpg,png,gif,webp',
            'state' => ['sometimes', 'nullable', Rule::in(ProductStateProxy::values())],
            'gtin' => ['bail', 'sometimes', 'nullable', new MustBeAValidGtin()],
        ];
    }

    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'stock' => $this->stock ?? 0,
        ]);
    }
}
