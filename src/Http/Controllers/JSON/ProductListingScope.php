<?php

declare(strict_types=1);

/**
 * Contains the ProductListingScope class.
 *
 * @copyright   Copyright (c) 2024 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2024-02-13
 *
 */

namespace Vanilo\Admin\Http\Controllers\JSON;

use Konekt\Enum\Enum;

/**
 * @method static self LISTING()
 * @method static self BUYABLES()
 *
 * @method bool isListing()
 * @method bool isBuyables()
 */
class ProductListingScope extends Enum
{
    public const __DEFAULT = self::LISTING;
    public const LISTING = 'listing';
    public const BUYABLES = 'buyables';
}
