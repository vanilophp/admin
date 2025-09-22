<?php

declare(strict_types=1);

namespace Vanilo\Admin\Filters;

use Illuminate\Database\Eloquent\Builder;
use Konekt\AppShell\Contracts\Filter;
use Konekt\AppShell\Filters\Concerns\DoesNotAllowMultipleValues;
use Konekt\AppShell\Filters\Concerns\HasBaseFilterAttributes;
use Konekt\AppShell\Filters\Concerns\HasPlaceholderSetter;
use Konekt\AppShell\Filters\Concerns\HasWidgetType;

class ProductSorter implements Filter
{
    use HasBaseFilterAttributes;
    use HasPlaceholderSetter;
    use HasWidgetType;
    use DoesNotAllowMultipleValues;

    public const CREATED_DESC = 'newest_first';
    public const CREATED_ASC = 'oldest_first';
    public const NAME_ASC = 'name_asc';
    public const NAME_DESC = 'name_desc';
    public const SALES_ASC = 'sales_asc';
    public const SALES_DESC = 'sales_desc';

    public const LAST_SALE_DESC = 'most_recent_sales';
    public const LAST_SALE_ASC = 'least_recent_sales';

    public const PRIORITY_DESC = 'priority_desc';
    public const PRIORITY_ASC = 'priority_asc';

    public function __construct()
    {
        $this->id = 'order_by';
        $this->possibleValues = [
            self::CREATED_DESC => __('Newest first'),
            self::CREATED_ASC => __('Oldest first'),
            self::PRIORITY_DESC => __('Priority order'),
            self::PRIORITY_ASC => __('Priority reverse'),
            self::NAME_ASC => __('Name (A-Z)'),
            self::NAME_DESC => __('Name (Z-A)'),
            self::SALES_ASC => __('Least sold first'),
            self::SALES_DESC => __('Most sold first'),
            self::LAST_SALE_DESC => __('Recently sold first'),
            self::LAST_SALE_ASC => __('Longest ago sold first'),
        ];
        $this->label = __('Order by');
    }

    public function apply(Builder $query, $criteria): Builder
    {
        return $query;
    }
}
