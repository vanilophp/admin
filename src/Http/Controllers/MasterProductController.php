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
use Vanilo\Admin\Contracts\Requests\CreateMasterProduct;
use Vanilo\Admin\Contracts\Requests\UpdateMasterProduct;
use Vanilo\Category\Models\TaxonomyProxy;
use Vanilo\MasterProduct\Contracts\MasterProduct;
use Vanilo\MasterProduct\Models\MasterProductProxy;
use Vanilo\Product\Models\ProductStateProxy;
use Vanilo\Properties\Models\PropertyProxy;

class MasterProductController extends BaseController
{
    public function create()
    {
        return view('vanilo::master-product.create', [
            'product' => app(MasterProduct::class),
            'states' => ProductStateProxy::choices()
        ]);
    }

    public function show(MasterProduct $product)
    {
        return view('vanilo::master-product.show', [
            'product' => $product,
            'taxonomies' => TaxonomyProxy::all(),
            'properties' => PropertyProxy::all()
        ]);
    }

    public function store(CreateMasterProduct $request)
    {
        try {
            $product = MasterProductProxy::create($request->except('images'));
            flash()->success(__(':name has been created', ['name' => $product->name]));

            try {
                if (!empty($request->files->filter('images'))) {
                    $product->addMultipleMediaFromRequest(['images'])->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection();
                    });
                }
            } catch (\Exception $e) { // Here we already have the product created
                flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

                return redirect()->route('vanilo.admin.master_product.edit', ['product' => $product]);
            }
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.admin.product.index'));
    }

    public function edit(MasterProduct $product)
    {
        return view('vanilo::master-product.edit', [
            'product' => $product,
            'states' => ProductStateProxy::choices()
        ]);
    }

    public function update(MasterProduct $product, UpdateMasterProduct $request)
    {
        try {
            $product->update($request->all());

            flash()->success(__(':name has been updated', ['name' => $product->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.admin.master_product.show', $product));
    }
}
