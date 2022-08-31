<?php

declare(strict_types=1);

/**
 * Contains the MasterProductController class.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-08-30
 *
 */

namespace Vanilo\Admin\Http\Controllers;

use Konekt\AppShell\Http\Controllers\BaseController;
use Vanilo\MasterProduct\Contracts\MasterProduct;
use Vanilo\Product\Models\ProductStateProxy;

class MasterProductController extends BaseController
{
    public function create()
    {
        return view('vanilo::master-product.create', [
            'product' => app(MasterProduct::class),
            'states' => ProductStateProxy::choices()
        ]);
    }
}
