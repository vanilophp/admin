<?php

declare(strict_types=1);

/**
 * Contains the CreateCarrier class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-01-25
 *
 */

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Vanilo\Admin\Contracts\Requests\CreateCarrier as CreateCarrierContract;

class CreateCarrier extends FormRequest implements CreateCarrierContract
{
    public function rules()
    {
        return [
            'name' => 'required|min:1|max:255',
            'configuration' => 'sometimes|json',
            'is_active' => 'sometimes|boolean',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
