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
    public function rules(): array
    {
        return [
            'name' => 'required|min:1|max:255',
            'sku' => [
                'required',
                'max:255',
                Rule::unique('master_product_variants')->ignore($this->route('masterProductVariant')->id),
            ],
            'price' => 'nullable|numeric',
            'original_price' => 'sometimes|nullable|numeric',
            'shipping_category_id' => 'sometimes|nullable|integer|exists:shipping_categories,id',
            'tax_category_id' => 'sometimes|nullable|integer|exists:tax_categories,id', // This field is not present on the form
            'stock' => 'nullable|numeric',
            'backorder' => 'nullable|numeric|min:0',
            'excerpt' => 'sometimes|nullable|string|max:16383',
            'description' => 'sometimes|nullable|string',
            'priority' => 'sometimes|integer',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpg,jpeg,pjpg,png,gif,webp',
            'state' => ['sometimes', 'nullable', Rule::in(ProductStateProxy::values())],
            'gtin' => ['bail', 'sometimes', 'nullable', new MustBeAValidGtin()],
            'subtitle' => 'sometimes|nullable|string|max:255',
            'slug' => 'sometimes|nullable|string|max:255',
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

    protected function prepareForValidation()
    {
        $this->merge([
            'stock' => $this->stock ?? 0,
        ]);
    }
}
