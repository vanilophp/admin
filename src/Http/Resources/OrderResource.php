<?php

declare(strict_types=1);

/**
 * Contains the OrderResource class.
 *
 * @copyright   Copyright (c) 2024 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2024-07-04
 *
 */

namespace Vanilo\Admin\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'billpayer' => $this->whenLoaded('billpayer', fn ($billpayer) => new BillpayerResource($billpayer)),
            'items' => $this->whenLoaded('items'),
            'total' => $this->total,
            'currency' => $this->currency,
            'language' => $this->language,
            'ordered_at' => $this->ordered_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
