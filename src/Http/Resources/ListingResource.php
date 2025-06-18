<?php

declare(strict_types=1);

namespace Vanilo\Admin\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Vanilo\Contracts\Buyable;

class ListingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        if ($this->resource instanceof Buyable) {
            $morphTypeName = $this->resource->morphTypeName();
        } else {
            $morphTypeName = shorten($this->resource::class);
        }

        return [
            'id' => $this->id,
            'name' => $this->resource->name,
            'price' => $this->resource->getPrice(),
            'thumbnail' => $this->resource->getThumbnailUrl(),
            'morph_type_name' => $morphTypeName,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
