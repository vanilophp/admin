<?php

declare(strict_types=1);
/**
 * Contains the UpdateProduct request class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-10-19
 *
 */

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Vanilo\Admin\Contracts\Requests\UpdateProduct as UpdateProductContract;
use Vanilo\Product\Models\ProductStateProxy;
use Vanilo\Support\Validation\Rules\MustBeAValidGtin;

class UpdateProduct extends FormRequest implements UpdateProductContract
{
    public function rules(): array
    {
        return [
            'name' => 'required|min:1|max:255',
            'sku' => [
                'required',
                'max:255',
                Rule::unique('products')->ignore($this->route('product')->id),
            ],
            'state' => ['required', 'max:255', Rule::in(ProductStateProxy::values())],
            'tax_category_id' => 'sometimes|nullable|integer|exists:tax_categories,id',
            'shipping_category_id' => 'sometimes|nullable|integer|exists:shipping_categories,id',
            'price' => 'nullable|numeric',
            'original_price' => 'sometimes|nullable|numeric',
            'stock' => 'nullable|numeric',
            'backorder' => 'nullable|numeric|min:0',
            'priority' => 'sometimes|integer',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpg,jpeg,pjpg,png,gif,webp',
            'gtin' => ['bail', 'sometimes', 'nullable', new MustBeAValidGtin()],
            'excerpt' => 'sometimes|nullable|string|max:16383',
            'meta_keywords' => 'sometimes|nullable|string|max:2047',
            'meta_description' => 'sometimes|nullable|string|max:4095',
            'ext_title' => 'sometimes|nullable|string|max:511',
            'subtitle' => 'sometimes|nullable|string|max:255',
            'slug' => 'sometimes|nullable|string|max:255',
            'description' => 'sometimes|nullable|string',
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

    public function attributesForCreate(): array
    {
        $except = ['id', 'deleted_at', 'updated_at', 'created_at', 'units_sold', 'last_sale_at'];
        return $this->validated(array_keys($this->rules()),['']);
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'stock' => $this->stock ?? 0,
        ]);
    }
}
