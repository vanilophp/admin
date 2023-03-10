<?php

declare(strict_types=1);

/**
 * Contains the CreateZone class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-03-10
 *
 */

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Konekt\Address\Models\ZoneScopeProxy;
use Vanilo\Admin\Contracts\Requests\CreateZone as CreateZoneContract;

class CreateZone extends FormRequest implements CreateZoneContract
{
    public function rules()
    {
        return [
            'name' => 'required|min:1|max:255',
            'scope' => ['required', Rule::in(ZoneScopeProxy::values())],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
