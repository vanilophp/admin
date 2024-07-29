<?php

declare(strict_types=1);

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Vanilo\Admin\Contracts\Requests\UpdatePromotion as UpdatePromotionContract;

class UpdatePromotion extends FormRequest implements UpdatePromotionContract
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
            'starts_at' => 'required|date|before:ends_at',
            'ends_at' => 'required|date|after:starts_at',
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
