<?php

declare(strict_types=1);

/**
 * Contains the PaymentController class.
 *
 * @copyright   Copyright (c) 2024 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2024-07-08
 *
 */

namespace Vanilo\Admin\Http\Controllers\JSON;

use Illuminate\Http\Request;
use Vanilo\Admin\Http\Resources\PaymentResource;
use Vanilo\Payment\Models\PaymentProxy;

class PaymentController
{
    public static function index(Request $request)
    {
        $payments = PaymentProxy::with(['payable', 'method']);
        if ($request->has('hash')) {
            $payments->where('hash', $request->input('hash'));
        }

        return PaymentResource::collection($payments->paginate(100));
    }
}
