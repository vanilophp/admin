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
use Vanilo\Admin\Http\Rules\UniqueAcrossTables;
use Vanilo\Product\Models\ProductStateProxy;
use Vanilo\Support\Validation\Rules\MustBeAValidGtin;

class CreateMasterProductVariant extends FormRequest implements CreateMasterProductVariantContract
{
    public function rules(): array
    {
        return [
            'name' => 'required|min:1|max:255',
            'sku' => ['required', 'max:255', new UniqueAcrossTables(['products', 'master_product_variants'], 'sku')],
            'shipping_category_id' => 'sometimes|nullable|integer|exists:shipping_categories,id',
            'tax_category_id' => 'sometimes|nullable|integer|exists:tax_categories,id', // This field is not present on the form
            'price' => 'nullable|numeric',
            'original_price' => 'sometimes|nullable|numeric',
            'stock' => 'nullable|numeric',
            'priority' => 'sometimes|nullable|integer',
            'backorder' => 'nullable|numeric|min:0',
            'excerpt' => 'sometimes|nullable|string|max:16383',
            'description' => 'sometimes|nullable|string',
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
