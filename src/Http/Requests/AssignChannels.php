<?php

declare(strict_types=1);

/**
 * Contains the AssignChannels class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-09-08
 *
 */

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Konekt\AppShell\Http\Requests\HasFor;
use Vanilo\Admin\Contracts\Requests\AssignChannels as AssignChannelsContract;

class AssignChannels extends FormRequest implements AssignChannelsContract
{
    use HasFor;
    use HasChannels;

    protected array $allowedFor = ['product', 'master_product', 'shipping_method', 'payment_method', 'property', 'taxonomy'];

    public function rules()
    {
        return array_merge($this->getForRules(), [
            'channels' => 'sometimes|array',
        ]);
    }

    public function authorize(): bool
    {
        return true;
    }
}
