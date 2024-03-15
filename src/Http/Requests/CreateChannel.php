<?php

declare(strict_types=1);
/**
 * Contains the CreateChannel class.
 *
 * @copyright   Copyright (c) 2019 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2019-07-30
 *
 */

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Konekt\AppShell\Validation\CurrencyExists;
use Vanilo\Admin\Contracts\Requests\CreateChannel as CreateChannelContract;

class CreateChannel extends FormRequest implements CreateChannelContract
{
    public function rules()
    {
        return [
            'name' => 'required|min:1|max:255',
            'slug' => 'nullable|max:255',
            'currency' => ['sometimes', 'nullable', 'alpha:ascii', 'size:3', new CurrencyExists()],
            'configuration' => 'nullable|array',
            'domain' => 'sometimes|nullable|string|min:3|max:255',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
