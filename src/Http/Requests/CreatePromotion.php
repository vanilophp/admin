<?php

declare(strict_types=1);

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Konekt\AppShell\Validation\CurrencyExists;
use Vanilo\Admin\Contracts\Requests\CreatePromotion as CreatePromotionContract;


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
            'starts_at' => 'required|date|before:ends_at',
            'ends_at' => 'required|date|after:starts_at',
            'applies_to_discounted' => 'required|boolean',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'priority' => $this->priority ?? 10
        ]);
    }

    public function authorize()
    {
        return true;
    }
}
