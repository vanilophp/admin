<?php

declare(strict_types=1);

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Vanilo\Admin\Contracts\Requests\CreatePromotion as CreatePromotionContract;
use Vanilo\Admin\Http\Rules\StartsBeforeEnds;

class CreatePromotion extends FormRequest implements CreatePromotionContract
{
    public function rules()
    {
        return [
            'name' => 'required|string|min:1|max:255',
            'description' => 'nullable|string|min:1|max:65000',
            'priority' => 'required|integer|min:0',
            'is_exclusive' => 'required|boolean',
            'usage_limit' => 'nullable|integer|min:0',
            'is_coupon_based' => 'required|boolean',
            'starts_at' => 'sometimes|nullable|date',
            'ends_at' => ['sometimes', 'nullable', 'date', new StartsBeforeEnds()],
            'applies_to_discounted' => 'required|boolean',
        ];
    }

    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'priority' => $this->priority ?? 10
        ]);
    }
}
