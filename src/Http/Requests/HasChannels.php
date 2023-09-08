<?php

declare(strict_types=1);

/**
 * Contains the HasChannels trait.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-09-08
 *
 */

namespace Vanilo\Admin\Http\Requests;

trait HasChannels
{
    public function channels(): array
    {
        $channels = $this->input('channels');

        return is_array($channels) ? $channels : [];
    }
}
