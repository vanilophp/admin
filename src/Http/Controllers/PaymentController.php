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

namespace Vanilo\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Konekt\AppShell\Http\Controllers\BaseController;

class PaymentController extends BaseController
{
    public function index(Request $request)
    {
        if (request()->wantsJson()) {
            return JSON\PaymentController::index($request);
        }

        flash()->warning('The payment index is only available as JSON');

        return redirect()->back();
    }
}
