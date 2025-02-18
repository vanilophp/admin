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

    public const CREATED_DESC = 'Newest first';
    public const NAME_ASC = 'Name (A-Z)';
    public const NAME_DESC = 'Name (Z-A)';
    public const SALES_ASC = 'Lowest sales first';
    public const SALES_DESC = 'Highest sales first';

    public function __construct()
    {
        $this->id = 'order_by';
        $this->possibleValues = [
            self::CREATED_DESC => __('Newest first'),
            self::NAME_ASC => __('Name (A-Z)'),
            self::NAME_DESC => __('Name (Z-A)'),
            self::SALES_ASC => __('Lowest sales first'),
            self::SALES_DESC => __('Highest sales first'),
        ];
        $this->label = __('Order by');
    }

    public function apply(Builder $query, $criteria): Builder
    {
        return $query;
    }
}
