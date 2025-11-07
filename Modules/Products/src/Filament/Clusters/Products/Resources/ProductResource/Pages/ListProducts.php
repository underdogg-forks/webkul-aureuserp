<?php

namespace Modules\Products\Filament\Clusters\Products\Resources\ProductResource\Pages;

use Illuminate\Database\Eloquent\Builder;
use Modules\Products\Filament\Clusters\Products\Resources\ProductResource;
use Modules\Core\Filament\Resources\ProductResource\Pages\ListProducts as BaseListProducts;
use Modules\Core\Filament\Components\PresetView;

class ListProducts extends BaseListProducts
{
    protected static string $resource = ProductResource::class;

    public function getPresetTableViews(): array
    {
        return array_merge(parent::getPresetTableViews(), [
            'storable_products' => PresetView::make(__('inventories::filament/clusters/products/resources/product/pages/list-products.tabs.inventory-management'))
                ->icon('heroicon-s-clipboard-document-list')
                ->favorite()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_storable', true)),
        ]);
    }
}
