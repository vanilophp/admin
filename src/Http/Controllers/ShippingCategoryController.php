<?php

declare(strict_types=1);

namespace Vanilo\Admin\Http\Controllers;

use Konekt\AppShell\Http\Controllers\BaseController;
use Vanilo\Admin\Contracts\Requests\CreateShippingCategory;
use Vanilo\Admin\Contracts\Requests\UpdateShippingCategory;
use Vanilo\Shipment\Contracts\ShippingCategory;
use Vanilo\Shipment\Models\ShippingCategoryProxy;

class ShippingCategoryController extends BaseController
{
    public function index()
    {
        return view('vanilo::shipping-category.index', [
            'shippingCategories' => ShippingCategoryProxy::orderBy('name')->get()
        ]);
    }

    public function create()
    {
        return view('vanilo::shipping-category.create', [
            'shippingCategory' => app(ShippingCategory::class),
        ]);
    }

    public function store(CreateShippingCategory $request)
    {
        try {
            $shippingCategory = ShippingCategoryProxy::create($request->validated());
            flash()->success(__(':name has been created', ['name' => $shippingCategory->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.admin.shipping-category.index'));
    }

    public function show(ShippingCategory $shippingCategory)
    {
        return view('vanilo::shipping-category.show', [
            'shippingCategory' => $shippingCategory,
        ]);
    }

    public function edit(ShippingCategory $shippingCategory)
    {
        return view('vanilo::shipping-category.edit', [
            'shippingCategory' => $shippingCategory,
        ]);
    }

    public function update(ShippingCategory $shippingCategory, UpdateShippingCategory $request)
    {
        try {
            $shippingCategory->update($request->validated());

            flash()->success(__(':name has been updated', ['name' => $shippingCategory->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.admin.shipping-category.index'));
    }

    public function destroy(ShippingCategory $shippingCategory)
    {
        try {
            $name = $shippingCategory->name;
            $shippingCategory->delete();

            flash()->warning(__(':name has been deleted', ['name' => $name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('vanilo.admin.shipping-category.index'));
    }
}
