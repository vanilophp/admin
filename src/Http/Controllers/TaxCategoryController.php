<?php

declare(strict_types=1);

/**
 * Contains the TaxCategoryController class.
 *
 * @copyright   Copyright (c) 2024 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2024-02-22
 *
 */

namespace Vanilo\Admin\Http\Controllers;

use Konekt\AppShell\Http\Controllers\BaseController;
use Vanilo\Admin\Contracts\Requests\CreateTaxCategory;
use Vanilo\Admin\Contracts\Requests\UpdateTaxCategory;
use Vanilo\Taxes\Contracts\TaxCategory;
use Vanilo\Taxes\Models\TaxCategoryProxy;
use Vanilo\Taxes\Models\TaxCategoryTypeProxy;
use Vanilo\Taxes\Models\TaxRateProxy;

class TaxCategoryController extends BaseController
{
    public function index()
    {
        return view('vanilo::tax-category.index', [
            'taxCategories' => TaxCategoryProxy::all()
        ]);
    }

    public function create()
    {
        return view('vanilo::tax-category.create', [
            'taxCategory' => app(TaxCategory::class),
            'types' => TaxCategoryTypeProxy::choices(),
        ]);
    }

    public function store(CreateTaxCategory $request)
    {
        try {
            $taxCategory = TaxCategoryProxy::create($request->validated());
            flash()->success(__(':name has been created', ['name' => $taxCategory->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.admin.tax-category.index'));
    }

    public function show(TaxCategory $taxCategory)
    {
        return view('vanilo::tax-category.show', [
            'taxCategory' => $taxCategory,
            'taxRates' => TaxRateProxy::byTaxCategory($taxCategory)->get(),
        ]);
    }

    public function edit(TaxCategory $taxCategory)
    {
        return view('vanilo::tax-category.edit', [
            'taxCategory' => $taxCategory,
            'types' => TaxCategoryTypeProxy::choices(),
        ]);
    }

    public function update(TaxCategory $taxCategory, UpdateTaxCategory $request)
    {
        try {
            $taxCategory->update($request->validated());

            flash()->success(__(':name has been updated', ['name' => $taxCategory->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.admin.tax-category.index'));
    }

    public function destroy(TaxCategory $taxCategory)
    {
        if (TaxRateProxy::byTaxCategory($taxCategory)->count() > 0) {
            flash()->warning(__('Can not delete this tax category as long as it has tax rates assigned to it.'));

            return redirect()->back();
        }

        try {
            $name = $taxCategory->name;
            $taxCategory->delete();

            flash()->warning(__(':name has been deleted', ['name' => $name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('vanilo.admin.tax-category.index'));
    }
}
