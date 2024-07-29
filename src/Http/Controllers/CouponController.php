<?php

declare(strict_types=1);

namespace Vanilo\Admin\Http\Controllers;

use Vanilo\Promotion\Contracts\Promotion;

class CouponController
{
    public function create(Promotion $promotion)
    {
        dd($promotion);
    }
}
