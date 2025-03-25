<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Konekt\AppShell\Theme\ThemeColor;
use Vanilo\Category\Contracts\Taxon;
use Vanilo\Category\Contracts\Taxonomy;
use Vanilo\Product\Contracts\Product;
use Vanilo\Promotion\Contracts\Promotion;
use Vanilo\Promotion\Models\PromotionStatus;
use Vanilo\Video\VideoDrivers;

if (!function_exists('admin_link_to')) {
    function admin_link_to(Model $model, string $operation = 'view'): ?string
    {
        return match (true) {
            is_master_product($model) => route('vanilo.admin.master_product.show', $model),
            is_master_product_variant($model) => route('vanilo.admin.master_product_variant.edit', [$model->masterProduct, $model]),
            $model instanceof Product => route('vanilo.admin.product.show', $model),
            $model instanceof Taxon => route('vanilo.admin.taxon.edit', [$model->taxonomy_id, $model]),
            $model instanceof Taxonomy => route('vanilo.admin.taxonomy.show', [$model]),
            default => null,
        };
    }
}

if (!function_exists('vnl_promo_status_color')) {
    function vnl_admin_promo_status_color(PromotionStatus $status): string
    {
        return match ($status) {
            PromotionStatus::Inactive => ThemeColor::WARNING,
            PromotionStatus::Active => ThemeColor::SUCCESS,
            PromotionStatus::Expired => ThemeColor::SECONDARY,
            PromotionStatus::Depleted => ThemeColor::INFO,
        };
    }
}

if (!function_exists('vnl_promo_validity_text')) {
    function vnl_promo_validity_text(Promotion $promotion): string
    {
        if (null === $promotion->starts_at) {
            return null === $promotion->ends_at ? __('does not expire') : __('expires at :datetime', ['datetime' => show_datetime($promotion->ends_at)]);
        }
        // it has a start date
        if ($promotion->starts_at->isFuture()) {
            return
                null === $promotion->ends_at ?
                    __('will start at :datetime and will not expire', ['datetime' => show_datetime($promotion->starts_at)])
                    :
                    __('will start at :starttime and expire at :endtime', ['starttime' => show_datetime($promotion->starts_at), 'endtime' => show_datetime($promotion->ends_at)]);
        }

        if (null !== $promotion->ends_at && $promotion->ends_at->isPast()) {
            return __('expired at :endtime', ['endtime' => show_datetime($promotion->ends_at)]);
        }

        return
            null === $promotion->ends_at ?
                __('started at :datetime and will not expire', ['datetime' => show_datetime($promotion->starts_at)])
                :
                __('started at :starttime and will expire at :endtime', ['starttime' => show_datetime($promotion->starts_at), 'endtime' => show_datetime($promotion->ends_at)]);
    }
}

if (!function_exists('vnl_video_drivers')) {
    function vnl_video_drivers(): array
    {
        $result = [
            null => [
                'name' => '--',
                'referenceIs' => __('Reference'),
            ],
        ];
        foreach (VideoDrivers::ids() as $id) {
            if (null !== $class = VideoDrivers::getClassOf($id)) {
                $result[$id] = [
                    'name' => $class::getName(),
                    'referenceIs' => $class::whatIsReference(),
                ];
            }
        }

        return $result;
    }
}
