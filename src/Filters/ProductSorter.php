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

    public const CREATED_DESC = 'Created desc';
    public const NAME_ASC = 'Name asc';
    public const NAME_DESC = 'Name desc';
    public const SALES_ASC = 'Sales asc';
    public const SALES_DESC = 'Sales desc';

    public function __construct()
    {
        $this->id = 'order_by';
        $this->possibleValues = [
            self::CREATED_DESC => __('Created Desc'),
            self::NAME_ASC => __('Name Asc'),
            self::NAME_DESC => __('Name Desc'),
            self::SALES_ASC => __('Sales Asc'),
            self::SALES_DESC => __('Sales Desc'),
        ];
        $this->label = __('Order by');
    }

    public function apply(Builder $query, $criteria): Builder
    {
        return $query;
    }
}
