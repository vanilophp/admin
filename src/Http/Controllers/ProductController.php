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

use Illuminate\Pagination\LengthAwarePaginator;
use Konekt\AppShell\Http\Controllers\BaseController;
use Vanilo\Admin\Contracts\Requests\CreateProduct;
use Vanilo\Admin\Contracts\Requests\UpdateProduct;
use Vanilo\Category\Models\TaxonomyProxy;
use Vanilo\MasterProduct\Models\MasterProductProxy;
use Vanilo\Product\Contracts\Product;
use Vanilo\Product\Models\ProductProxy;
use Vanilo\Product\Models\ProductStateProxy;
use Vanilo\Properties\Models\PropertyProxy;

class ProductController extends BaseController
{
    public function index()
    {
        $products = ProductProxy::query()->paginate(50);
        $masterProducts = MasterProductProxy::query()->paginate(50);

        $paginator = new LengthAwarePaginator(
            collect($products->items())->merge($masterProducts->items()),
            $products->total() + $masterProducts->total(),
            100,
        ) ;

        return view('vanilo::product.index', [
            'products' => $paginator,
        ]);
    }

    public function create()
    {
        return view('vanilo::product.create', [
            'product' => app(Product::class),
            'states' => ProductStateProxy::choices()
        ]);
    }

    public function store(CreateProduct $request)
    {
        try {
            $product = ProductProxy::create($request->except('images'));
            flash()->success(__(':name has been created', ['name' => $product->name]));

            try {
                if (!empty($request->files->filter('images'))) {
                    $product->addMultipleMediaFromRequest(['images'])->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection();
                    });
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
            'properties' => PropertyProxy::all()
        ]);
    }

    public function edit(Product $product)
    {
        return view('vanilo::product.edit', [
            'product' => $product,
            'states' => ProductStateProxy::choices()
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
            $product->delete();

            flash()->warning(__(':name has been deleted', ['name' => $name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('vanilo.admin.product.index'));
    }
}
