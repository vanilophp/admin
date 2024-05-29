<?php

declare(strict_types=1);

/**
 * Contains the HasSourceModel trait.
 *
 * @copyright   Copyright (c) 2024 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2024-05-29
 *
 */

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Database\Eloquent\Model;

trait HasSourceModel
{
    use ResolvesModelClass;

    public function getSourceModel(): ?Model
    {
        if (null === $class = $this->resolveModelClass($this->input('source_type'))) {
            return null;
        }

        return $class::find($this->input('source_id'));
    }
}
