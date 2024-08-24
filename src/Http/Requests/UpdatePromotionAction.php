<?php

declare(strict_types=1);

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Vanilo\Admin\Contracts\Requests\UpdatePromotionAction as UpdatePromotionActionContract;
use Vanilo\Promotion\PromotionActionTypes;

class UpdatePromotionAction extends FormRequest implements UpdatePromotionActionContract
{
    public function rules()
    {
        return [
            'type' => ['required', Rule::in(PromotionActionTypes::ids())],
            'configuration' => 'sometimes|json',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
