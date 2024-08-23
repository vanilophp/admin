<?php

declare(strict_types=1);

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Vanilo\Admin\Contracts\Requests\UpdatePromotionRule as UpdatePromotionRuleContract;
use Vanilo\Promotion\PromotionRuleTypes;

class UpdatePromotionRule extends FormRequest implements UpdatePromotionRuleContract
{
    public function rules()
    {
        return [
            'type' => ['required', Rule::in(PromotionRuleTypes::ids())],
            'configuration' => 'sometimes|json',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
