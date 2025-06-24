<?php

declare(strict_types=1);

/**
 * Contains the MasterProductVariantController class.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-12-20
 *
 */

namespace Vanilo\Admin\Http\Controllers;

use Konekt\AppShell\Http\Controllers\BaseController;
use Vanilo\Admin\Contracts\Requests\CreateMasterProductVariant;
use Vanilo\Admin\Contracts\Requests\UpdateMasterProductVariant;
use Vanilo\Links\Models\LinkTypeProxy;
use Vanilo\MasterProduct\Contracts\MasterProduct;
use Vanilo\MasterProduct\Contracts\MasterProductVariant;
use Vanilo\MasterProduct\Models\MasterProductVariantProxy;
use Vanilo\Product\Models\ProductStateProxy;
use Vanilo\Properties\Models\PropertyProxy;
use Vanilo\Shipment\Models\ShippingCategoryProxy;

class MasterProductVariantController extends BaseController
{
    public function create(MasterProduct $masterProduct)
    {
        return view('vanilo::master-product-variant.create', [
            'master' => $masterProduct,
            'variant' => app(MasterProductVariant::class),
            'states' => ProductStateProxy::choices(),
            'shippingCategories' => ShippingCategoryProxy::get(['name', 'id']),
        ]);
    }

    public function store(MasterProduct $masterProduct, CreateMasterProductVariant $request)
    {
        try {
            $variant = MasterProductVariantProxy::create(
                array_merge(
                    [
                        'master_product_id' => $masterProduct->id,
                        'tax_category_id' => $masterProduct->tax_category_id,
                    ],
                    $request->except('images')
                )
            );
            $masterProduct->touch();

            flash()->success(__(':name has been created', ['name' => $variant->name]));

            try {
                if (!empty($request->files->filter('images'))) {
                    $variant->addMultipleMediaFromRequest(['images'])->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection();
                    });
                }
            } catch (\Exception $e) { // Here we already have the variant created
                flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

                return redirect()
                    ->route(
                        'vanilo.admin.master_product_variant.edit',
                        [$masterProduct, $variant],
                    );
            }
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.admin.master_product.show', $masterProduct));
    }

    public function show(MasterProduct $masterProduct, MasterProductVariant $masterProductVariant)
    {
        return redirect()
            ->route('vanilo.admin.master_product_variant.edit', [$masterProduct, $masterProductVariant]);
    }

    public function edit(MasterProduct $masterProduct, MasterProductVariant $masterProductVariant)
    {
        return view('vanilo::master-product-variant.edit', [
            'master' => $masterProduct,
            'variant' => $masterProductVariant,
            'states' => ProductStateProxy::choices(),
            'properties' => PropertyProxy::all(),
            'linkTypes' => LinkTypeProxy::choices(false, true),
            'shippingCategories' => ShippingCategoryProxy::get(['name', 'id']),
        ]);
    }

    public function update(MasterProduct $masterProduct, MasterProductVariant $masterProductVariant, UpdateMasterProductVariant $request)
    {
        try {
            $masterProductVariant->update($request->all());
            $masterProduct->touch();

            flash()->success(__(':name has been updated', ['name' => $masterProductVariant->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect()->route('vanilo.admin.master_product.show', $masterProduct);
    }

    public function destroy(MasterProduct $masterProduct, MasterProductVariant $masterProductVariant)
    {
        try {
            $name = $masterProductVariant->name;
            $masterProductVariant->propertyValues()->detach();
            $masterProductVariant->delete();
            $masterProduct->touch();

            flash()->warning(__(':name has been deleted', ['name' => $name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect()->route('vanilo.admin.master_product.show', $masterProduct);
    }
}
