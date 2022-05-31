<?php

declare(strict_types=1);

/**
 * Contains the SkuMode class.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-05-31
 *
 */

namespace Vanilo\Admin\Models;

use Konekt\Enum\Enum;
use Vanilo\Admin\Contracts\SkuMode as SkuModeContract;

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
class SkuMode extends Enum implements SkuModeContract
{
    public const __DEFAULT = self::MANUAL;

    public const MANUAL = 'manual';
    public const USE_ID = 'use_id';
    public const NANOID = 'nanoid';

    protected static $labels = [];

    protected static function boot()
    {
        static::$labels = [
            self::MANUAL => __('Manual entry'),
            self::USE_ID => __('Use the product id'),
            self::NANOID => __('Generate Nanoid'),
        ];
    }
}
