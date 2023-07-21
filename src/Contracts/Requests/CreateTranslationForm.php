<?php

declare(strict_types=1);

/**
 * Contains the CreateTranslationForm interface.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-07-21
 *
 */

namespace Vanilo\Admin\Contracts\Requests;

use Konekt\Concord\Contracts\BaseRequest;

interface CreateTranslationForm extends BaseRequest
{
    public function getFor();

    public function getLanguage(): string;
}
