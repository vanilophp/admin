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

class UpdateProduct extends FormRequest implements UpdateProductContract
{
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'sku' => [
                'required',
                Rule::unique('products')->ignore($this->route('product')->id),
                ],
            'state' => ['required', Rule::in(ProductStateProxy::values())],
            'price' => 'nullable|numeric',
            'original_price' => 'sometimes|nullable|numeric',
            'stock' => 'nullable|numeric',
            'backorder' => 'nullable|numeric|min:0',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpg,jpeg,pjpg,png,gif,webp',
            'gtin' => 'sometimes|nullable|string|max:255',
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
