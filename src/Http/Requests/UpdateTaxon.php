<?php

declare(strict_types=1);
/**
 * Contains the UpdateTaxon class.
 *
 * @copyright   Copyright (c) 2018 Hunor Kedves
 * @author      Hunor Kedves
 * @license     MIT
 * @since       2018-10-23
 *
 */

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Vanilo\Admin\Contracts\Requests\UpdateTaxon as UpdateTaxonContract;

class UpdateTaxon extends FormRequest implements UpdateTaxonContract
{
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
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
        ];
    }

    public function authorize()
    {
        return true;
    }
}
