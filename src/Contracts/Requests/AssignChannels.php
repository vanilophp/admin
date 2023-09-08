<?php

declare(strict_types=1);

/**
 * Contains the AssignChannels interface.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-09-08
 *
 */

namespace Vanilo\Admin\Contracts\Requests;

use Konekt\Concord\Contracts\BaseRequest;

interface AssignChannels extends BaseRequest
{
    public function channels(): array;

    public function getFor();
}
