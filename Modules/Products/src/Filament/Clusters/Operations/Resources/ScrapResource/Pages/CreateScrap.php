<?php

namespace Modules\Products\Filament\Clusters\Operations\Resources\ScrapResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;
use Modules\Products\Enums\ScrapState;
use Modules\Products\Filament\Clusters\Operations\Resources\ScrapResource;
use Modules\Products\Models\Location;
use Modules\Products\Models\Product;
use Modules\Products\Models\Warehouse;

class CreateScrap extends CreateRecord
{
    protected static string $resource = ScrapResource::class;

    public function getSubNavigation(): array
    {
        if (filled($cluster = static::getCluster())) {
            return $this->generateNavigationItems($cluster::getClusteredComponents());
        }

        return [];
    }

    public function getTitle(): string|Htmlable
    {
        return __('inventories::filament/clusters/operations/resources/scrap/pages/create-scrap.title');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['uom_id'] ??= Product::find($data['product_id'])->uom_id;

        $data['state'] ??= ScrapState::DRAFT;

        $data['creator_id'] = Auth::id();

        $data['source_location_id'] ??= Warehouse::first()->lot_stock_location_id;

        $data['destination_location_id'] ??= Location::where('is_scrap', true)->first()->id;

        $data['company_id'] ??= Auth::user()->default_company_id;

        return $data;
    }
}
