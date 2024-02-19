<?php

declare(strict_types=1);

/**
 * Contains the CanShowChannelsForUi trait.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-09-08
 *
 */

namespace Vanilo\Admin\Http\Controllers;

use Vanilo\Channel\Models\ChannelProxy;
use Vanilo\Support\Features;

trait CanShowChannelsForUi
{
    protected function channelsForUi(): array
    {
        if (Features::isMultiChannelDisabled()) {
            return [];
        }

        return ChannelProxy::pluck('name', 'id')->toArray();
    }
}
