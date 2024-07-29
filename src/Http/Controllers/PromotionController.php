<?php

declare(strict_types=1);

/**
 * Contains the PromotionController class.
 *
 * @copyright   Copyright (c) 2024 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2024-07-26
 *
 */

namespace Vanilo\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Konekt\AppShell\Http\Controllers\BaseController;

use Vanilo\Admin\Contracts\Requests\CreatePromotion;
use Vanilo\Admin\Contracts\Requests\UpdatePromotion;
use Vanilo\Promotion\Models\Promotion;
use Vanilo\Promotion\Models\PromotionProxy;

class PromotionController extends BaseController
{
    public function index()
    {
        return view('vanilo::promotion.index', [
            'promotions' => PromotionProxy::paginate(100),
        ]);
    }

    public function create()
    {
        return view('vanilo::promotion.create', [
            'promotion' => app(Promotion::class),
        ]);
    }

    public function store(CreatePromotion $request)
    {
        try {
            $promotion = PromotionProxy::create($request->validated());

            flash()->success(__(':name has been created', ['name' => $promotion->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.admin.promotion.index'));
    }

    public function show(Promotion $promotion)
    {
        return view('vanilo::promotion.show', [
            'promotion' => $promotion,
        ]);
    }

    public function edit(Promotion $promotion)
    {
        return view('vanilo::promotion.edit', [
            'promotion' => $promotion,
        ]);
    }

    public function update(Promotion $promotion, UpdatePromotion $request)
    {
        try {
            $promotion->update($request->validated());

            flash()->success(__(':name has been updated', ['name' => $promotion->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.admin.promotion.index'));
    }

    public function destroy(Promotion $promotion)
    {
        try {
            $name = $promotion->name;
            $promotion->delete();

            flash()->warning(__(':name has been deleted', ['name' => $name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('vanilo.admin.promotion.index'));
    }
}
