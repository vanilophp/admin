<?php

declare(strict_types=1);

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Vanilo\Admin\Contracts\Requests\CreatePromotionAction as CreatePromotionActionContract;
use Vanilo\Promotion\PromotionActionTypes;

class CreatePromotionAction extends FormRequest implements CreatePromotionActionContract
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
