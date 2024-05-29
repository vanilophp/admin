<?php

declare(strict_types=1);

/**
 * Contains the ResolvesModelClass trait.
 *
 * @copyright   Copyright (c) 2024 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2024-05-29
 *
 */

namespace Vanilo\Admin\Http\Requests;

use Vanilo\MasterProduct\Models\MasterProductProxy;
use Vanilo\MasterProduct\Models\MasterProductVariantProxy;
use Vanilo\Product\Models\ProductProxy;

trait ResolvesModelClass
{
    protected function resolveModelClass(string $shortName): ?string
    {
        return match ($shortName) {
            null, 'product' => ProductProxy::modelClass(),
            'master_product' => MasterProductProxy::modelClass(),
            'master_product_variant' => MasterProductVariantProxy::modelClass(),
            default => null,
        };
    }
}
