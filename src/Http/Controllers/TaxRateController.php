<?php

declare(strict_types=1);

/**
 * Contains the TaxRateController class.
 *
 * @copyright   Copyright (c) 2024 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2024-02-22
 *
 */

namespace Vanilo\Admin\Http\Controllers;

use Konekt\Address\Query\Zones;
use Konekt\AppShell\Http\Controllers\BaseController;
use Vanilo\Admin\Contracts\Requests\CreateTaxRate;
use Vanilo\Admin\Contracts\Requests\UpdateTaxRate;
use Vanilo\Taxes\Contracts\TaxRate;
use Vanilo\Taxes\Models\TaxCategoryProxy;
use Vanilo\Taxes\Models\TaxRateProxy;
use Vanilo\Taxes\TaxCalculators;

class TaxRateController extends BaseController
{
    public function index()
    {
        return view('vanilo::tax-rate.index', [
            'taxRates' => TaxRateProxy::with(['taxCategory', 'zone'])->get(),
        ]);
    }

    public function create()
    {
        return view('vanilo::tax-rate.create', [
            'taxRate' => app(TaxRate::class),
            'taxCategories' => TaxCategoryProxy::get(['id', 'name']),
            'calculators' => TaxCalculators::choices(),
            'zones' => Zones::withTaxationScope()->get(),
        ]);
    }

    public function store(CreateTaxRate $request)
    {
        try {
            $attributes = $request->validated();
            $attributes['configuration'] = json_decode($attributes['configuration']);
            $taxRate = TaxRateProxy::create($attributes);
            flash()->success(__(':name has been created', ['name' => $taxRate->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.admin.tax-rate.index'));
    }

    public function show(TaxRate $taxRate)
    {
        return view('vanilo::tax-rate.show', [
            'taxRate' => $taxRate,
        ]);
    }

    public function edit(TaxRate $taxRate)
    {
        return view('vanilo::tax-rate.edit', [
            'taxRate' => $taxRate,
            'taxCategories' => TaxCategoryProxy::get(['id', 'name']),
            'calculators' => TaxCalculators::choices(),
            'zones' => Zones::withTaxationScope()->get(),
        ]);
    }

    public function update(TaxRate $taxRate, UpdateTaxRate $request)
    {
        try {
            $attributes = $request->validated();
            $attributes['configuration'] = json_decode($attributes['configuration']);
            $taxRate->update($attributes);

            flash()->success(__(':name has been updated', ['name' => $taxRate->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.admin.tax-rate.index'));
    }

    public function destroy(TaxRate $taxRate)
    {
        try {
            $name = $taxRate->name;
            $taxRate->delete();

            flash()->warning(__(':name has been deleted', ['name' => $name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('vanilo.admin.tax-rate.index'));
    }
}
