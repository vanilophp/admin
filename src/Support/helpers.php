<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Vanilo\Product\Contracts\Product;

if (!function_exists('admin_link_to')) {
    function admin_link_to(Model $model, string $operation = 'view'): ?string
    {
        return match (true) {
            is_master_product($model) => route('vanilo.admin.master_product.show', $model),
            is_master_product_variant($model) => route('vanilo.admin.master_product_variant.edit', [$model->masterProduct, $model]),
            $model instanceof Product => route('vanilo.admin.product.show', $model),
            default => null,
        };
    }
}
