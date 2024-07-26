<?php

declare(strict_types=1);

/**
 * Contains the PromotionController class.
 *
 * @copyright   Copyright (c) 2024 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2024-07-26
 *
 */

namespace Vanilo\Admin\Http\Controllers;

use Konekt\AppShell\Http\Controllers\BaseController;

class PromotionController extends BaseController
{
    public function index()
    {
        return view('vanilo::promotion.index', ['promotions' => collect()]);
    }
}
