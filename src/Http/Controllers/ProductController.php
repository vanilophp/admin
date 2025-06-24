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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;
use Konekt\AppShell\Filters\Filters;
use Konekt\AppShell\Filters\Generic\ExactMatch;
use Konekt\AppShell\Filters\Generic\PartialMatch;
use Konekt\AppShell\Filters\PartialMatchPattern;
use Konekt\AppShell\Http\Controllers\BaseController;
use Konekt\AppShell\Widgets;
use Konekt\AppShell\Widgets\AppShellWidgets;
use Vanilo\Admin\Contracts\Requests\CreateProduct;
use Vanilo\Admin\Contracts\Requests\UpdateProduct;
use Vanilo\Admin\Filters\ProductSorter;
use Vanilo\Category\Models\TaxonomyProxy;
use Vanilo\Links\Models\LinkTypeProxy;
use Vanilo\MasterProduct\Models\MasterProductProxy;
use Vanilo\Product\Contracts\Product;
use Vanilo\Product\Models\ProductProxy;
use Vanilo\Product\Models\ProductStateProxy;
use Vanilo\Properties\Models\PropertyProxy;
use Vanilo\Shipment\Models\ShippingCategoryProxy;
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

        $productsQuery = ProductProxy::query()->with($with);
        $masterProductsQuery = MasterProductProxy::query()->with($with);

        $filters = $this->getFilters();
        $filters->activateFromRequest($request);

        $productsQuery = $filters->apply($productsQuery);
        $masterProductsQuery = $filters->apply($masterProductsQuery);

        $products = $productsQuery->get();
        $masterProducts = $masterProductsQuery->get();

        $items = collect()->push($products, $masterProducts)
                        ->lazy()
                        ->flatten()
                        ->sortByDesc('created_at');

        if ($request->filled('order_by')) {
            $items = match ($request->input('order_by')) {
                ProductSorter::CREATED_ASC => $items->sortBy('created_at'),
                ProductSorter::NAME_ASC => $items->sortBy('name'),
                ProductSorter::NAME_DESC => $items->sortByDesc('name'),
                ProductSorter::SALES_ASC => $items->sortBy('units_sold'),
                ProductSorter::SALES_DESC => $items->sortByDesc('units_sold'),
                ProductSorter::LAST_SALE_DESC => $items->sortByDesc('last_sale_at'),
                ProductSorter::LAST_SALE_ASC => $items->sortBy('last_sale_at'),
                default => $items,
            };
        }

        return view('vanilo::product.index', [
            'products' => $items->paginate(100)->withPath(route('vanilo.admin.product.index')),
            'filters' => Widgets::make(AppShellWidgets::FILTER_SET, [
                'route' => 'vanilo.admin.product.index',
                'filters' => $filters,
            ])
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
            'shippingCategories' => ShippingCategoryProxy::get(['name', 'id']),
        ]);
    }

    public function store(CreateProduct $request)
    {
        try {
            DB::beginTransaction();

            $product = ProductProxy::create($request->except(['images', 'channels']));
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

            return redirect()->route('vanilo.admin.product.edit', ['product' => $product]);
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
            'shippingCategories' => ShippingCategoryProxy::get(['name', 'id']),
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
            DB::beginTransaction();

            $product->removeFromAllChannels();
            $product->propertyValues()->detach();
            $product->delete();

            DB::commit();
            flash()->warning(__(':name has been deleted', ['name' => $name]));
        } catch (\Exception $e) {
            DB::rollBack();
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('vanilo.admin.product.index'));
    }

    protected function getFilters(): Filters
    {
        $filters = [
            (new PartialMatch('name', __('Name'), PartialMatchPattern::ANYWHERE()))->displayAsTextField(),
            new ExactMatch(
                'state',
                __('State'),
                [null => __('Any state')] + ProductStateProxy::choices(),
            ),
            new ProductSorter(),
        ];

        return Filters::make($filters);
    }
}
