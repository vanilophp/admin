<?php

declare(strict_types=1);

namespace Vanilo\Admin\Filters;

use Illuminate\Database\Eloquent\Builder;
use Konekt\AppShell\Contracts\Filter;
use Konekt\AppShell\Filters\Generic\PartialMatch;
use Konekt\AppShell\Filters\PartialMatchPattern;

class ProductSkuFilter extends PartialMatch
{
    public function __construct()
    {
        parent::__construct('sku', __('SKU'), PartialMatchPattern::ANYWHERE());
        $this->displayAsTextField();
    }
    public function apply(Builder $query, $criteria): Builder
    {
        if ($query->from === 'products') {
            return parent::apply($query, $criteria);
        } elseif ($query->from === 'master_products') {
            return $query->whereHas('variants', function ($query) use ($criteria) {
                return $query->where('sku', 'like', PartialMatchPattern::ANYWHERE()->sqlExpression($criteria));
            });
        }

        return $query;
    }
}
