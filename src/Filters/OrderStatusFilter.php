<?php

declare(strict_types=1);

/**
 * Contains the OrderStatusFilter class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-01-26
 *
 */

namespace Vanilo\Admin\Filters;

use Illuminate\Database\Eloquent\Builder;
use Konekt\AppShell\Contracts\Filter;
use Konekt\AppShell\Filters\Concerns\DoesNotAllowMultipleValues;
use Konekt\AppShell\Filters\Concerns\HasBaseFilterAttributes;
use Konekt\AppShell\Filters\Concerns\HasPlaceholderSetter;
use Konekt\AppShell\Filters\Concerns\HasWidgetType;
use Vanilo\Order\Contracts\OrderStatus;
use Vanilo\Order\Models\OrderStatusProxy;

class OrderStatusFilter implements Filter
{
    public const OPEN = 'open';
    public const CLOSED = 'closed';
    public const ANY = 'any';

    use HasBaseFilterAttributes;
    use HasPlaceholderSetter;
    use HasWidgetType;
    use DoesNotAllowMultipleValues;

    public function __construct()
    {
        $this->id = 'status';
        $this->possibleValues = [
            self::ANY => __('Any Status'),
            self::OPEN => __('Open orders'),
            self::CLOSED => __('Closed orders'),
            __('Specific Status') => OrderStatusProxy::choices(),
        ];
        $this->label = __('Order status');
    }

    public function apply(Builder $query, $criteria): Builder
    {
        if ($criteria instanceof OrderStatus) {
            $criteria = $criteria->value();
        }

        return match ($criteria) {
            self::ANY => $query,
            self::OPEN => $query->whereIn($this->id, OrderStatusProxy::getOpenStatuses()),
            self::CLOSED => $query->whereNotIn($this->id, OrderStatusProxy::getOpenStatuses()),
            default => $query->where($this->id, $criteria),
        };
    }
}
