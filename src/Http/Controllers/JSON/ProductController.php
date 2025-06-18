<?php

declare(strict_types=1);

/**
 * Contains the ProductController class.
 *
 * @copyright   Copyright (c) 2024 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2024-02-13
 *
 */

namespace Vanilo\Admin\Http\Controllers\JSON;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Konekt\Search\Facades\Search;
use Konekt\Search\Searcher;
use Vanilo\Admin\Http\Resources\BuyableResource;
use Vanilo\Admin\Http\Resources\ListingResource;
use Vanilo\MasterProduct\Models\MasterProductProxy;
use Vanilo\MasterProduct\Models\MasterProductVariantProxy;
use Vanilo\Product\Models\ProductProxy;
use Vanilo\Product\Models\ProductStateProxy;

class ProductController
{
    protected Searcher $searcher;

    protected Builder $productQuery;

    protected ?Builder $masterProductQuery = null;

    protected ?Builder $masterProductVariantQuery = null;

    public function __construct(
        protected ProductListingScope $scope
    ) {
        $this->searcher = Search::new();
        $this->productQuery = ProductProxy::query();

        if ($this->scope->isListing()) {
            $this->masterProductQuery = MasterProductProxy::query();
        } else {
            $this->masterProductVariantQuery = MasterProductVariantProxy::query();
        }
    }

    public static function index(Request $request)
    {
        $scope = self::obtainScope($request);

        $instance = new self($scope);

        if ($request->has('sku')) {
            $instance->havingSku((string) $request->input('sku'));
        } elseif ($request->has('name')) {
            $instance->havingName((string) $request->input('name'));
        }

        return match ($scope->value()) {
            ProductListingScope::BUYABLES => BuyableResource::collection($instance->getResults()),
            ProductListingScope::LISTING => ListingResource::collection($instance->getResults()),
        };
    }

    protected static function obtainScope(Request $request): ProductListingScope
    {
        if ($request->has('scope') && ProductListingScope::has($request->input('scope'))) {
            return ProductListingScope::create($request->input('scope'));
        };

        if ($request->has(['sku'])) {
            return ProductListingScope::BUYABLES();
        }

        return ProductListingScope::create();
    }

    protected function havingSku(string $sku): self
    {
        $this->productQuery->where('sku', $sku);
        $this->masterProductVariantQuery?->where('sku', $sku);

        return $this;
    }

    protected function havingName(string $name): self
    {
        // Return nothing in case of empty name
        if ($name === '') {
            $this->productQuery->whereRaw('1 = 0');
            $this->masterProductQuery?->whereRaw('1 = 0');
        }

        $this->productQuery->whereRaw("LOWER(name) LIKE LOWER(?)", ["%$name%"]);
        $this->masterProductQuery?->whereRaw('LOWER(name) LIKE LOWER(?)', ["%$name%"]);

        return $this;
    }

    protected function withoutInactiveProducts(): self
    {
        $this->productQuery->withGlobalScope('withoutInactiveProducts', function (Builder $queryBuilder) {
            return $queryBuilder->whereIn('state', ProductStateProxy::getActiveStates());
        });
        $this->masterProductQuery?->withGlobalScope('withoutInactiveProducts', function (Builder $queryBuilder) {
            return $queryBuilder->whereIn('state', ProductStateProxy::getActiveStates());
        });
        $this->masterProductVariantQuery?->withGlobalScope('withoutInactiveProducts', function (Builder $queryBuilder) {
            return $queryBuilder->whereIn('state', ProductStateProxy::getActiveStates());
        });

        return $this;
    }

    protected function getSearcher(): Searcher
    {
        $this->searcher->add($this->productQuery);

        return match ($this->scope->value()) {
            ProductListingScope::LISTING => $this->searcher->add($this->masterProductQuery),
            ProductListingScope::BUYABLES => $this->searcher->add($this->masterProductVariantQuery),
        };
    }

    protected function getResults(): Collection
    {
        return $this->getSearcher()->search();
    }
}
