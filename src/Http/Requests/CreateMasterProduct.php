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
    use HasChannels;

    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'state' => ['required', Rule::in(ProductStateProxy::values())],
            'tax_category_id' => 'sometimes|nullable|exists:tax_categories,id',
            'shipping_category_id' => 'sometimes|nullable|exists:shipping_categories,id',
            'price' => 'nullable|numeric',
            'original_price' => 'nullable|numeric',
            'description' => 'nullable|string',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpg,jpeg,pjpg,png,gif,webp',
            'channels' => 'sometimes|array',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
