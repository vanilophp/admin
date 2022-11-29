<?php

declare(strict_types=1);

/**
 * Contains the CreateMasterProduct class.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-11-28
 *
 */

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Vanilo\Admin\Contracts\Requests\CreateMasterProduct as CreateMasterProductContract;
use Vanilo\Product\Models\ProductStateProxy;

class CreateMasterProduct extends FormRequest implements CreateMasterProductContract
{
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'state' => ['required', Rule::in(ProductStateProxy::values())],
            'price' => 'nullable|numeric',
            'original_price' => 'nullable|numeric',
            'description' => 'nullable|string',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif'
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
