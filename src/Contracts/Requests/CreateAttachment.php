<?php

declare(strict_types=1);

/**
 * Contains the CreateAttachment request interface.
 *
 * @copyright   Copyright (c) 2026 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2026-10-29
 *
 */

namespace Vanilo\Admin\Contracts\Requests;

use Illuminate\Database\Eloquent\Model;
use Konekt\Concord\Contracts\BaseRequest;

interface CreateAttachment extends BaseRequest
{
    /**
     * Returns the model the attachment(s) need to be added for
     *
     * @return null|Model
     */
    public function getFor();
}
