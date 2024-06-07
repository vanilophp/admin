<?php

declare(strict_types=1);
/**
 * Contains the CreateTaxon class.
 *
 * @copyright   Copyright (c) 2018 Hunor Kedves
 * @author      Hunor Kedves
 * @license     MIT
 * @since       2018-10-22
 *
 */

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Vanilo\Admin\Contracts\Requests\CreateTaxon as CreateTaxonContract;

class CreateTaxon extends FormRequest implements CreateTaxonContract
{
    public function rules()
    {
        return [
            'name' => 'required|string|min:2|max:255',
            'slug' => 'sometimes|nullable|string|max:255',
            'parent_id' => 'nullable|exists:taxons,id',
            'priority' => 'nullable|integer',
            'ext_title' => 'sometimes|nullable|string|max:511',
            'meta_description' => 'sometimes|nullable|string|max:4096',
            'meta_keywords' => 'sometimes|nullable|string|max:1024',
            'subtitle' => 'sometimes|nullable|string|max:255',
            'excerpt' => 'sometimes|nullable|string|max:65534',
            'description' => 'sometimes|nullable|string|max:65534',
            'top_content' => 'sometimes|nullable|string|max:65534',
            'bottom_content' => 'sometimes|nullable|string|max:65534',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpg,jpeg,pjpg,png,gif,webp',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
