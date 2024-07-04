<?php

declare(strict_types=1);

/**
 * Contains the OrderController class.
 *
 * @copyright   Copyright (c) 2024 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2024-07-04
 *
 */

namespace Vanilo\Admin\Http\Controllers\JSON;

use Illuminate\Http\Request;
use Vanilo\Admin\Http\Resources\OrderResource;
use Vanilo\Order\Models\OrderProxy;

class OrderController
{
    public static function index(Request $request)
    {
        $orders = OrderProxy::with(['billpayer', 'items']);
        if ($request->has('number')) {
            $orders->where('number', $request->input('number'));
        }

        return OrderResource::collection($orders->paginate(100));
    }
}
