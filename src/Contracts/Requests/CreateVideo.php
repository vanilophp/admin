<?php

declare(strict_types=1);

namespace Vanilo\Admin\Contracts\Requests;

use Konekt\Concord\Contracts\BaseRequest;

interface CreateVideo extends BaseRequest
{
    public function getFor();
}
