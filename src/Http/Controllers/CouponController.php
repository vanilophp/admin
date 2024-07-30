<?php

declare(strict_types=1);

namespace Vanilo\Admin\Http\Controllers;

use Vanilo\Admin\Contracts\Requests\CreateCoupon;
use Vanilo\Admin\Contracts\Requests\UpdateCoupon;
use Vanilo\Promotion\Contracts\Coupon;
use Vanilo\Promotion\Contracts\Promotion;
use Vanilo\Promotion\Models\CouponProxy;

class CouponController
{
    public function create(Promotion $promotion)
    {
        return view('vanilo::coupon.create', [
            'promotion' => $promotion,
            'coupon' => app(Coupon::class),
        ]);
    }

    public function store(Promotion $promotion, CreateCoupon $request)
    {
        try {
            $coupon = CouponProxy::create(
                array_merge(
                    [
                        'promotion_id' => $promotion->id,
                    ],
                    $request->validated(),
                )
            );

            flash()->success(__(':code has been created', ['code' => $coupon->code]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.admin.promotion.show', $promotion));
    }

    public function show(Promotion $promotion, Coupon $coupon)
    {
        return view('vanilo::coupon.show', [
            'promotion' => $promotion,
            'coupon' => $coupon,
        ]);
    }

    public function edit(Promotion $promotion, Coupon $coupon)
    {
        return view('vanilo::coupon.edit', [
            'promotion' => $promotion,
            'coupon' => $coupon,
        ]);
    }

    public function update(Promotion $promotion, Coupon $coupon, UpdateCoupon $request)
    {
        try {
            $coupon->update($request->validated());

            flash()->success(__(':code has been updated', ['code' => $coupon->code]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect()->route('vanilo.admin.promotion.show', $promotion);
    }

    public function destroy(Promotion $promotion, Coupon $coupon)
    {
        try {
            $code = $coupon->code;
            $coupon->delete();

            flash()->warning(__(':code has been deleted', ['code' => $code]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect()->route('vanilo.admin.promotion.show', $promotion);
    }
}
