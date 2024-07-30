<?php

declare(strict_types=1);

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Vanilo\Admin\Contracts\Requests\UpdateCoupon as UpdateCouponContract;

class UpdateCoupon extends FormRequest implements UpdateCouponContract
{
    public function rules()
    {
        $coupon = $this->route('coupon');

        return [
            'code' => ['required', 'string', Rule::unique('coupons')->ignore($coupon), 'min:1', 'max:255'],
            'usage_limit' => 'nullable|integer|min:0',
            'per_customer_usage_limit' => 'nullable|integer|min:0',
            'expires_at' => 'sometimes|nullable|date',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
