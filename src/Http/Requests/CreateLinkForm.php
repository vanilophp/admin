<?php

declare(strict_types=1);

/**
 * Contains the CreateLinkForm class.
 *
 * @copyright   Copyright (c) 2024 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2024-05-29
 *
 */

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Vanilo\Admin\Contracts\Requests\CreateLinkForm as CreateLinkFormContract;

class CreateLinkForm extends FormRequest implements CreateLinkFormContract
{
    use HasSourceModel;

    public static array $acceptedTypes = ['product', 'master_product', 'master_product_variant'];

    public function rules(): array
    {
        return [
            'source_type' => ['sometimes', 'nullable', 'string', Rule::in(self::$acceptedTypes)],
            'source_id' => 'required|numeric',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
