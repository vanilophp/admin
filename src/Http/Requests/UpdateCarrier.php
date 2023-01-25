<?php

declare(strict_types=1);

/**
 * Contains the UpdateCarrier class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-01-25
 *
 */

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Vanilo\Admin\Contracts\Requests\UpdateCarrier as UpdateCarrierContract;

class UpdateCarrier extends FormRequest implements UpdateCarrierContract
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
