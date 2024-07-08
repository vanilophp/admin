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

class PaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'hash' => $this->hash,
            'remote_id' => $this->remote_id,
            'subtype' => $this->subtype,
            'payable_id' => $this->payable_id,
            'payable_type' => $this->payable_type,
            'order' => $this->whenLoaded('payable', fn ($payable) => new OrderResource($payable)),
            'payment_method_id' => $this->payment_method_id,
            'method' => $this->whenLoaded('method', fn ($method) => new PaymentMethodResource($method)),
            'status' => $this->status->value(),
            'status_message' => $this->status_message,
            'data' => $this->data,
            'amount' => $this->amount,
            'amount_paid' => $this->amount_paid,
            'currency' => $this->currency,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
