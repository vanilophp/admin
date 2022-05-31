<?php

declare(strict_types=1);

/**
 * Contains the SkuMode interface.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-05-31
 *
 */

namespace Vanilo\Admin\Contracts;

/**
 * @method static SkuMode MANUAL()
 * @method static SkuMode USE_ID()
 * @method static SkuMode NANOID()
 *
 * @method bool isManual()
 * @method bool isUseId()
 * @method bool isNanoid()
 *
 * @property-read bool is_manual
 * @property-read bool is_use_id
 * @property-read bool is_nanoid
 */
interface SkuMode
{
    /** @return string */
    public function value();

    /** @return string */
    public function label();
}
