<?php

declare(strict_types=1);

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Vanilo\Admin\Contracts\Requests\CreateCoupon as CreateCouponContract;

class CreateCoupon extends FormRequest implements CreateCouponContract
{
    public function rules()
    {
        return [
            'code' => 'required|string|unique:coupons|min:1|max:255',
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
