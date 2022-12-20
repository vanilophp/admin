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
use Vanilo\MasterProduct\Contracts\MasterProduct;
use Vanilo\MasterProduct\Contracts\MasterProductVariant;
use Vanilo\MasterProduct\Models\MasterProductVariantProxy;
use Vanilo\Product\Models\ProductStateProxy;

class MasterProductVariantController extends BaseController
{
    public function create(MasterProduct $masterProduct)
    {
        return view('vanilo::master-product-variant.create', [
            'master' => $masterProduct,
            'variant' => app(MasterProductVariant::class),
            'states' => ProductStateProxy::choices()
        ]);
    }

    public function store(MasterProduct $masterProduct, CreateMasterProductVariant $request)
    {
        try {
            $variant = MasterProductVariantProxy::create(
                array_merge(['master_product_id' => $masterProduct->id], $request->except('images'))
            );
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
                        'vanilo.admin.master-product-variant.edit',
                        ['masterProduct' => $masterProduct, 'variant' => $variant],
                    );
            }
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.admin.product.index'));
    }

    public function edit(MasterProduct $masterProduct, MasterProductVariant $masterProductVariant)
    {
        return view('vanilo::master-product-variant.edit', [
            'master' => $masterProduct,
            'variant' => $masterProductVariant,
            'states' => ProductStateProxy::choices()
        ]);
    }

    public function update(MasterProduct $masterProduct, MasterProductVariant $masterProductVariant, UpdateMasterProductVariant $request)
    {
        try {
            $masterProductVariant->update($request->all());

            flash()->success(__(':name has been updated', ['name' => $masterProductVariant->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.admin.master-product.show', $masterProduct));
    }
}
