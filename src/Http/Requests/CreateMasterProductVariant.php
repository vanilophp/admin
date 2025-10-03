<?php

declare(strict_types=1);

/**
 * Contains the CreateMasterProductVariant class.
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
use Vanilo\Admin\Contracts\Requests\CreateMasterProductVariant as CreateMasterProductVariantContract;
use Vanilo\Product\Models\ProductStateProxy;
use Vanilo\Support\Validation\Rules\MustBeAValidGtin;

class CreateMasterProductVariant extends FormRequest implements CreateMasterProductVariantContract
{
    public function rules()
    {
        return [
            'name' => 'required|min:1|max:255',
            'sku' => 'required|unique:products',
            'shipping_category_id' => 'sometimes|nullable|exists:shipping_categories,id',
            'price' => 'nullable|numeric',
            'original_price' => 'sometimes|nullable|numeric',
            'stock' => 'nullable|numeric',
            'priority' => 'sometimes|nullable|integer',
            'backorder' => 'nullable|numeric|min:0',
            'excerpt' => 'sometimes|nullable|max:8192',
            'description' => 'sometimes|nullable|max:32768',
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
