<?php

namespace Modules\Core\Filament\Clusters\Configuration\Resources\TaxResource\Pages;

use Filament\Pages\Enums\SubNavigationPosition;
use Modules\Core\Filament\Resources\TaxResource\Pages\ViewTax as BaseViewTax;
use Modules\Core\Filament\Clusters\Configuration\Resources\TaxResource;

class ViewTax extends BaseViewTax
{
    protected static string $resource = TaxResource::class;

    public static function getSubNavigationPosition(): SubNavigationPosition
    {
        return SubNavigationPosition::Start;
    }

    public function getSubNavigation(): array
    {
        if (filled($cluster = static::getCluster())) {
            return $this->generateNavigationItems($cluster::getClusteredComponents());
        }

        return [];
    }
}
