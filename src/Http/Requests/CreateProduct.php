<?php

declare(strict_types=1);
/**
 * Contains the CreateProduct request class.
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
use Vanilo\Admin\Contracts\Requests\CreateProduct as CreateProductContract;
use Vanilo\Product\Models\ProductStateProxy;
use Vanilo\Support\Validation\Rules\MustBeAValidGtin;

class CreateProduct extends FormRequest implements CreateProductContract
{
    use HasChannels;

    public function rules(): array
    {
        return [
            'name' => 'required|min:1|max:255',
            'sku' => 'required|max:255|unique:products',
            'state' => ['required', 'max:255', Rule::in(ProductStateProxy::values())],
            'tax_category_id' => 'sometimes|nullable|integer|exists:tax_categories,id',
            'shipping_category_id' => 'sometimes|nullable|integer|exists:shipping_categories,id',
            'price' => 'nullable|numeric',
            'original_price' => 'sometimes|nullable|numeric',
            'stock' => 'nullable|numeric',
            'backorder' => 'nullable|numeric|min:0',
            'priority' => 'sometimes|nullable|integer',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpg,jpeg,pjpg,png,gif,webp',
            'channels' => 'sometimes|array',
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

    protected function prepareForValidation(): void
    {
        $this->merge([
            'stock' => $this->stock ?? 0,
        ]);

        // Do not force the user to enter a priority when we can default it to zero
        if ($this->has('priority') && is_null($this->input('priority'))) {
            $this->merge([
                'priority' => 0,
            ]);
        }
    }
}
