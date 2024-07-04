<?php

declare(strict_types=1);

/**
 * Contains the Product controller class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-10-19
 *
 */

namespace Vanilo\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\LazyCollection;
use Konekt\AppShell\Http\Controllers\BaseController;
use Vanilo\Admin\Contracts\Requests\CreateProduct;
use Vanilo\Admin\Contracts\Requests\UpdateProduct;
use Vanilo\Category\Models\TaxonomyProxy;
use Vanilo\Links\Models\LinkTypeProxy;
use Vanilo\MasterProduct\Models\MasterProductProxy;
use Vanilo\Product\Contracts\Product;
use Vanilo\Product\Models\ProductProxy;
use Vanilo\Product\Models\ProductStateProxy;
use Vanilo\Properties\Models\PropertyProxy;
use Vanilo\Support\Features;
use Vanilo\Taxes\Models\TaxCategoryProxy;

class ProductController extends BaseController
{
    use CanShowChannelsForUi;

    public function index(Request $request)
    {
        if (request()->wantsJson()) {
            return JSON\ProductController::index($request);
        }

        LazyCollection::macro('paginate', function ($perPage = 100, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });

        /** @todo this solution requires significant improvement. It loads all the records in the memory! */
        $with = ['taxons', 'media'];
        if (Features::isMultiChannelEnabled()) {
            $with[] = 'channels';
        }
        $products = ProductProxy::query()->with($with)->get();
        $masterProducts = MasterProductProxy::query()->with($with)->get();

        $items = collect()->push($products, $masterProducts)->lazy()->flatten()->sortByDesc('created_at');

        return view('vanilo::product.index', [
                'products' => $items->paginate(100)->withPath(route('vanilo.admin.product.index')),
        ]);
    }

    public function create()
    {
        return view('vanilo::product.create', [
            'product' => app(Product::class),
            'states' => ProductStateProxy::choices(),
            'multiChannelEnabled' => Features::isMultiChannelEnabled(),
            'channels' => $this->channelsForUi(),
            'taxCategories' => TaxCategoryProxy::get(['name', 'id']),
        ]);
    }

    public function store(CreateProduct $request)
    {
        try {
            $product = ProductProxy::create($request->except(['images', 'channels']));
            flash()->success(__(':name has been created', ['name' => $product->name]));

            try {
                if (!empty($request->files->filter('images'))) {
                    $product->addMultipleMediaFromRequest(['images'])->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection();
                    });
                }
                if (Features::isMultiChannelEnabled()) {
                    $product->assignChannels($request->channels());
                }
            } catch (\Exception $e) { // Here we already have the product created
                flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

                return redirect()->route('vanilo.admin.product.edit', ['product' => $product]);
            }
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.admin.product.index'));
    }

    public function show(Product $product)
    {
        return view('vanilo::product.show', [
            'product' => $product,
            'taxonomies' => TaxonomyProxy::all(),
            'properties' => PropertyProxy::all(),
            'multiChannelEnabled' => Features::isMultiChannelEnabled(),
            'linkTypes' => LinkTypeProxy::choices(false, true),
        ]);
    }

    public function edit(Product $product)
    {
        return view('vanilo::product.edit', [
            'product' => $product,
            'states' => ProductStateProxy::choices(),
            'multiChannelEnabled' => Features::isMultiChannelEnabled(),
            'channels' => $this->channelsForUi(),
            'taxCategories' => TaxCategoryProxy::get(['name', 'id']),
        ]);
    }

    public function update(Product $product, UpdateProduct $request)
    {
        try {
            $product->update($request->all());

            flash()->success(__(':name has been updated', ['name' => $product->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.admin.product.show', $product));
    }

    public function destroy(Product $product)
    {
        try {
            $name = $product->name;
            $product->removeFromAllChannels();
            $product->propertyValues()->detach();
            $product->delete();

            flash()->warning(__(':name has been deleted', ['name' => $name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('vanilo.admin.product.index'));
    }
}
