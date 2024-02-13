<?php

declare(strict_types=1);

/**
 * Contains the BuyableResource class.
 *
 * @copyright   Copyright (c) 2024 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2024-02-13
 *
 */

namespace Vanilo\Admin\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BuyableResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'name' => $this->resource->getName(),
            'price' => $this->resource->getPrice(),
            'thumbnail' => $this->resource->getThumbnailUrl(),
            'morph_type_name' => $this->resource->morphTypeName(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
