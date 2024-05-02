<?php

declare(strict_types=1);

use Vanilo\Foundation\Models\MasterProductVariant;

/*
┌──────────────────────────────────────────────────────────────────────────────────┐
│ These are Vanilo Admin Routes that are not under ACL directly.                   │
│                                                                                  │
│ The aim of these routes is to provide with alternative variants of the admin     │
│ routes. All the routes here should redirect to an ACL-based route.               │
└──────────────────────────────────────────────────────────────────────────────────┘
 */

Route::get('/master-product-variant/{variant}', function (MasterProductVariant $variant) {
    return redirect()->route('vanilo.admin.master_product_variant.show', [$variant->master_product_id, $variant->id]);
})->name('master_product_variant.show');
