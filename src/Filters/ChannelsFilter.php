<?php

declare(strict_types=1);

namespace Vanilo\Admin\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Konekt\AppShell\Contracts\Filter;
use Konekt\AppShell\Filters\Concerns\AllowsMultipleValues;
use Konekt\AppShell\Filters\Concerns\HasBaseFilterAttributes;
use Konekt\AppShell\Filters\Concerns\HasPlaceholderSetter;
use Konekt\AppShell\Filters\Concerns\HasWidgetType;
use Vanilo\Channel\Models\ChannelProxy;

class ChannelsFilter implements Filter
{
    use HasBaseFilterAttributes;
    use HasPlaceholderSetter;
    use HasWidgetType;
    use AllowsMultipleValues;

    public function __construct()
    {
        $this->id = 'channels';
        $this->possibleValues = ChannelProxy::all()->pluck('name', 'id')->toArray();
        $this->label = __('Channels');

        $this->displayAsMultiSelect();
        $this->setPlaceholder('Select Channels');
    }

    public function apply(Builder $query, $criteria): Builder
    {
        return $query->withinChannels(Arr::wrap($criteria));
    }
}
