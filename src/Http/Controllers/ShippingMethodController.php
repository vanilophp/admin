<?php

declare(strict_types=1);

/**
 * Contains the ShippingMethodController class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-01-25
 *
 */

namespace Vanilo\Admin\Http\Controllers;

use Konekt\Address\Query\Zones;
use Konekt\AppShell\Http\Controllers\BaseController;
use Vanilo\Admin\Contracts\Requests\CreateShippingMethod;
use Vanilo\Admin\Contracts\Requests\UpdateShippingMethod;
use Vanilo\Shipment\Contracts\ShippingMethod;
use Vanilo\Shipment\Models\CarrierProxy;
use Vanilo\Shipment\Models\ShippingMethodProxy;

class ShippingMethodController extends BaseController
{
    public function index()
    {
        return view('vanilo::shipping-method.index', [
            'shippingMethods' => ShippingMethodProxy::all()
        ]);
    }

    public function create()
    {
        return view('vanilo::shipping-method.create', [
            'shippingMethod' => app(ShippingMethod::class),
            'carriers' => CarrierProxy::all(),
        ]);
    }

    public function store(CreateShippingMethod $request)
    {
        try {
            $attributes = $request->validated();
            $attributes['configuration'] = json_decode($attributes['configuration']);
            $shippingMethod = ShippingMethodProxy::create($attributes);
            flash()->success(__(':name has been created', ['name' => $shippingMethod->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.admin.shipping-method.index'));
    }

    public function show(ShippingMethod $shippingMethod)
    {
        return view('vanilo::shipping-method.show', ['shippingMethod' => $shippingMethod]);
    }

    public function edit(ShippingMethod $shippingMethod)
    {
        return view('vanilo::shipping-method.edit', [
            'shippingMethod' => $shippingMethod,
            'carriers' => CarrierProxy::all(),
            'zones' => Zones::withShippingScope()->get(),
        ]);
    }

    public function update(ShippingMethod $shippingMethod, UpdateShippingMethod $request)
    {
        try {
            $attributes = $request->validated();
            $attributes['configuration'] = json_decode($attributes['configuration']);
            $shippingMethod->update($attributes);

            flash()->success(__(':name has been updated', ['name' => $shippingMethod->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.admin.shipping-method.index'));
    }

    public function destroy(ShippingMethod $shippingMethod)
    {
        try {
            $name = $shippingMethod->name;
            $shippingMethod->delete();

            flash()->warning(__(':name has been deleted', ['name' => $name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('vanilo.admin.shipping-method.index'));
    }
}
