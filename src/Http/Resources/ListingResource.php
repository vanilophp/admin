<?php

declare(strict_types=1);

namespace Vanilo\Admin\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->resource->name,
            'price' => $this->resource->getPrice(),
            'thumbnail' => $this->resource->getThumbnailUrl(),
            'morph_type_name' => morph_type_of($this->resource),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
