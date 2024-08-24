<?php

declare(strict_types=1);

namespace Vanilo\Admin\Http\Controllers;

use Konekt\AppShell\Http\Controllers\BaseController;
use Vanilo\Admin\Contracts\Requests\CreatePromotionRule;
use Vanilo\Admin\Contracts\Requests\UpdatePromotionRule;
use Vanilo\Promotion\Contracts\Promotion;
use Vanilo\Promotion\Contracts\PromotionRule;
use Vanilo\Promotion\Models\PromotionRuleProxy;
use Vanilo\Promotion\PromotionRuleTypes;

class PromotionRuleController extends BaseController
{
    public function create(Promotion $promotion)
    {
        return view('vanilo::promotion-rule.create', [
            'promotion' => $promotion,
            'rule' => app(PromotionRule::class),
            'types' => PromotionRuleTypes::choices(),
        ]);
    }

    public function store(Promotion $promotion, CreatePromotionRule $request)
    {
        try {
            $promotionRule = PromotionRuleProxy::create(
                array_merge(
                    [
                        'promotion_id' => $promotion->id,
                    ],
                    $request->validated(),
                )
            );

            flash()->success(__('Rule :title has been created', ['title' => $promotionRule->getTitle()]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.admin.promotion.show', $promotion));
    }

    public function edit(Promotion $promotion, PromotionRule $promotionRule)
    {
        return view('vanilo::promotion-rule.edit', [
            'promotion' => $promotion,
            'rule' => $promotionRule,
            'types' => PromotionRuleTypes::choices(),
        ]);
    }

    public function update(Promotion $promotion, PromotionRule $promotionRule, UpdatePromotionRule $request)
    {
        try {
            $promotionRule->update($request->validated());

            flash()->success(__('The rule :title has been updated', ['title' => $promotionRule->getTitle()]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect()->route('vanilo.admin.promotion.show', $promotion);
    }

    public function destroy(Promotion $promotion, PromotionRule $promotionRule)
    {
        try {
            $title = $promotionRule->getTitle();
            $promotionRule->delete();

            flash()->warning(__('The rule :title has been deleted', ['title' => $title]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect()->route('vanilo.admin.promotion.show', $promotion);
    }
}
