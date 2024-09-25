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

use Illuminate\Support\Facades\DB;
use Konekt\AppShell\Http\Controllers\BaseController;
use Vanilo\Admin\Contracts\Requests\CreateMasterProduct;
use Vanilo\Admin\Contracts\Requests\UpdateMasterProduct;
use Vanilo\Category\Models\TaxonomyProxy;
use Vanilo\Links\Models\LinkTypeProxy;
use Vanilo\MasterProduct\Contracts\MasterProduct;
use Vanilo\MasterProduct\Contracts\MasterProductVariant;
use Vanilo\MasterProduct\Models\MasterProductProxy;
use Vanilo\Product\Models\ProductStateProxy;
use Vanilo\Properties\Models\PropertyProxy;
use Vanilo\Support\Features;
use Vanilo\Taxes\Models\TaxCategoryProxy;

class MasterProductController extends BaseController
{
    use CanShowChannelsForUi;

    public function create()
    {
        return view('vanilo::master-product.create', [
            'product' => app(MasterProduct::class),
            'states' => ProductStateProxy::choices(),
            'multiChannelEnabled' => Features::isMultiChannelEnabled(),
            'channels' => $this->channelsForUi(),
            'taxCategories' => TaxCategoryProxy::get(['name', 'id']),
        ]);
    }

    public function show(MasterProduct $product)
    {
        return view('vanilo::master-product.show', [
            'product' => $product,
            'taxonomies' => TaxonomyProxy::all(),
            'properties' => PropertyProxy::all(),
            'multiChannelEnabled' => Features::isMultiChannelEnabled(),
            'linkTypes' => LinkTypeProxy::choices(false, true),
        ]);
    }

    public function store(CreateMasterProduct $request)
    {
        try {
            DB::beginTransaction();

            $product = MasterProductProxy::create($request->except('images'));
            if (Features::isMultiChannelEnabled()) {
                $product->assignChannels($request->channels());
            }

            DB::commit();
            flash()->success(__(':name has been created', ['name' => $product->name]));
        } catch (\Exception $e) {
            DB::rollBack();
            flash()->error(__('The product has not been created: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        try {
            if (!empty($request->files->filter('images'))) {
                $product->addMultipleMediaFromRequest(['images'])->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection();
                });
            }
        } catch (\Exception $e) { // Here we already have the product created
            flash()->warning(__('Error at adding the product images: :msg', ['msg' => $e->getMessage()]));

            return redirect()->route('vanilo.admin.master_product.edit', ['product' => $product]);
        }

        return redirect(route('vanilo.admin.product.index'));
    }

    public function edit(MasterProduct $product)
    {
        return view('vanilo::master-product.edit', [
            'product' => $product,
            'states' => ProductStateProxy::choices(),
            'multiChannelEnabled' => Features::isMultiChannelEnabled(),
            'channels' => $this->channelsForUi(),
            'taxCategories' => TaxCategoryProxy::get(['name', 'id']),
        ]);
    }

    public function update(MasterProduct $product, UpdateMasterProduct $request)
    {
        try {
            DB::transaction(function () use ($product, $request) {
                $wantsTaxCategoryUpdate = $product->tax_category_id !== $request->input('tax_category_id');
                $product->update($request->all());

                if ($wantsTaxCategoryUpdate) {
                    $product->variants()->update(['tax_category_id' => $request->input('tax_category_id')]);
                }
            });

            flash()->success(__(':name has been updated', ['name' => $product->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.admin.master_product.show', $product));
    }

    public function destroy(MasterProduct $product)
    {
        try {
            $name = $product->name;
            DB::transaction(function () use ($product) {
                $product->variants->each(function (MasterProductVariant $variant) {
                    $variant->propertyValues()->detach();
                    $variant->delete();
                });
                $product->propertyValues()->detach();
                $product->taxons()->detach();
                $product->removeFromAllChannels();
                $product->delete();
            });
            flash()->warning(__(':name has been deleted', ['name' => $name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('vanilo.admin.product.index'));
    }
}
