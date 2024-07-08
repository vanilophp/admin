<?php

declare(strict_types=1);

/**
 * Contains the PaymentResource class.
 *
 * @copyright   Copyright (c) 2024 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2024-07-08
 *
 */

namespace Vanilo\Admin\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'gateway' => $this->gateway,
            'gateway_name' => $this->getGateway()?->getName(),
            'gateway_icon' => $this->getGateway()?->svgIcon(),
            'configuration' => $this->configuration,
            'is_enabled' => (bool) $this->is_enabled,
            'transaction_count' => $this->transaction_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
