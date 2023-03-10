<?php

declare(strict_types=1);

/**
 * Contains the ZoneMemberController class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-03-10
 *
 */

namespace Vanilo\Admin\Http\Controllers;

use Konekt\Address\Contracts\Zone;
use Konekt\Address\Contracts\ZoneMember;
use Konekt\Address\Models\CountryProxy;
use Konekt\Address\Models\ProvinceProxy;
use Konekt\AppShell\Http\Controllers\BaseController;

class ZoneMemberController extends BaseController
{
    public function create(Zone $zone)
    {
        $zoneMember = app(ZoneMember::class);
        $zoneMember->zone_id = $zone->id;

        return view('vanilo::zone.create', [
            'zone' => $zone,
            'zoneMember' => $zone,
            'availableCountries' => CountryProxy::whereNotIn('id', $zone->getMemberCountryIds()),
            'availableProvinces' => ProvinceProxy::whereNotIn('id', $zone->getMemberProvinceIds()),
        ]);
    }
}
