<?php

declare(strict_types=1);

/**
 * Contains the CreateLinkForm interface.
 *
 * @copyright   Copyright (c) 2024 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2024-05-29
 *
 */

namespace Vanilo\Admin\Contracts\Requests;

use Illuminate\Database\Eloquent\Model;
use Konekt\Concord\Contracts\BaseRequest;
use Vanilo\Links\Contracts\LinkGroup;

interface CreateLinkForm extends BaseRequest
{
    public function getSourceModel(): ?Model;

    public function wantsToExtendAnExistingLinkGroup(): bool;

    public function getDesiredLinkGroup(): ?LinkGroup;
}
