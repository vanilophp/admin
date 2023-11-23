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
use Vanilo\Admin\Contracts\Requests\UpdateMasterProductVariant as UpdateMasterProductVariantContract;

class UpdateMasterProductVariant extends FormRequest implements UpdateMasterProductVariantContract
{
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'sku' => 'required|unique:products',
            'price' => 'nullable|numeric',
            'original_price' => 'sometimes|nullable|numeric',
            'stock' => 'nullable|numeric',
            'backorder' => 'nullable|numeric|min:0',
            'excerpt' => 'sometimes|nullable|max:8192',
            'description' => 'sometimes|nullable|max:32768',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpg,jpeg,pjpg,png,gif,webp'
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
