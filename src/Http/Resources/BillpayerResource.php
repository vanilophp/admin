<?php

declare(strict_types=1);

namespace Vanilo\Admin\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillpayerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'phone' => $this->phone,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'name' => $this->getFullName(),
            'company_name' => $this->company_name,
            'tax_nr' => $this->tax_nr,
            'registration_nr' => $this->registration_nr,
            'is_organization' => (bool) $this->is_organization,
            'country' => $this->address->country_id,
            'postalcode' => $this->address->postalcode,
            'city' => $this->address->city,
            'address' => $this->address->address,
            'avatar' => avatar_image_url($this, 26),
        ];
    }
}
