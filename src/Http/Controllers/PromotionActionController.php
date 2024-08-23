<?php

declare(strict_types=1);

namespace Vanilo\Admin\Http\Controllers;

use Konekt\AppShell\Http\Controllers\BaseController;
use Vanilo\Admin\Contracts\Requests\CreatePromotionAction;
use Vanilo\Admin\Contracts\Requests\UpdatePromotionAction;
use Vanilo\Promotion\Contracts\Promotion;
use Vanilo\Promotion\Contracts\PromotionAction;
use Vanilo\Promotion\Models\PromotionActionProxy;
use Vanilo\Promotion\PromotionActionTypes;

class PromotionActionController extends BaseController
{
    public function create(Promotion $promotion)
    {
        return view('vanilo::promotion-action.create', [
            'promotion' => $promotion,
            'action' => app(PromotionAction::class),
            'types' => PromotionActionTypes::choices(),
        ]);
    }

    public function store(Promotion $promotion, CreatePromotionAction $request)
    {
        try {
            $promotionAction = PromotionActionProxy::create(
                array_merge(
                    [
                        'promotion_id' => $promotion->id,
                    ],
                    $request->validated(),
                )
            );

            flash()->success(__('Action :title has been created', ['title' => $promotionAction->getTitle()]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.admin.promotion.show', $promotion));
    }

    public function edit(Promotion $promotion, PromotionAction $promotionAction)
    {
        return view('vanilo::promotion-action.edit', [
            'promotion' => $promotion,
            'action' => $promotionAction,
            'types' => PromotionActionTypes::choices(),
        ]);
    }

    public function update(Promotion $promotion, PromotionAction $promotionAction, UpdatePromotionAction $request)
    {
        try {
            $promotionAction->update($request->validated());

            flash()->success(__('The action :title has been updated', ['title' => $promotionAction->getTitle()]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect()->route('vanilo.admin.promotion.show', $promotion);
    }

    public function destroy(Promotion $promotion, PromotionAction $promotionAction)
    {
        try {
            $title = $promotionAction->getTitle();
            $promotionAction->delete();

            flash()->warning(__('The action :title has been deleted', ['title' => $title]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect()->route('vanilo.admin.promotion.show', $promotion);
    }
}
