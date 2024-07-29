<?php

namespace Vanilo\Admin\Http\Controllers;

use Vanilo\Promotion\Contracts\Promotion;

class CouponController
{
    public function create(Promotion $promotion)
    {
        dd($promotion);
    }
}
