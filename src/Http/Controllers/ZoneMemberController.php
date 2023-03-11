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
use Konekt\Address\Models\ZoneMemberProxy;
use Konekt\Address\Models\ZoneMemberType;
use Konekt\Address\Models\ZoneMemberTypeProxy;
use Konekt\AppShell\Http\Controllers\BaseController;
use Vanilo\Admin\Contracts\Requests\CreateZoneMember;

class ZoneMemberController extends BaseController
{
    public function create(Zone $zone)
    {
        $zoneMember = app(ZoneMember::class);
        $zoneMember->zone_id = $zone->id;
        $existingZoneCountryIds = $zone->getMemberCountryIds();
        $existingZoneProvinceIds = $zone->getMemberProvinceIds();
        $theZoneHasMoreProvincesThanCountries = count($existingZoneProvinceIds) > count($existingZoneCountryIds);
        $zoneMember->member_type = ZoneMemberTypeProxy::create($theZoneHasMoreProvincesThanCountries ? ZoneMemberType::PROVINCE : ZoneMemberType::COUNTRY);

        return view('vanilo::zone-member.create', [
            'zone' => $zone,
            'zoneMember' => $zoneMember,
            'zoneMemberTypes' => ZoneMemberTypeProxy::choices(),
            'availableCountries' => CountryProxy::whereNotIn('id', $existingZoneCountryIds)->pluck('name', 'id'),
            'availableProvinces' => ProvinceProxy::whereNotIn('id', $existingZoneProvinceIds)->pluck('name', 'id'),
        ]);
    }

    public function store(Zone $zone, CreateZoneMember $request)
    {
        try {
            $zoneMember = ZoneMemberProxy::create(
                array_merge(
                    $request->validated(),
                    ['zone_id' => $zone->id]
                )
            );

            flash()->success(__(':name has been added to :zone', [
                'name' => $zoneMember->getName(),
                'zone' => $zone->name
            ]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.admin.zone.show', $zone));
    }

    public function destroy(Zone $zone, ZoneMember $zoneMember)
    {
        try {
            $name = $zoneMember->getName();
            $zoneMember->delete();

            flash()->warning(__(':name has been removed from the :zone zone', ['name' => $name, 'zone' => $zone->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('vanilo.admin.zone.show', $zone));
    }
}
