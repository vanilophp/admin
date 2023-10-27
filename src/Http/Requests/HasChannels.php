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
        if (!is_array($result = $this->input('channels'))) {
            return [];
        }

        return array_unique(array_map('intval', array_map('trim', $result)));
    }

    public function hasChannels(): bool
    {
        return $this->has('channels');
    }
}
