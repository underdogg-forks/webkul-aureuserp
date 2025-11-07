<?php

namespace Modules\Core\Filament\Clusters\Configuration\Resources\TaxResource\Pages;

use Filament\Pages\Enums\SubNavigationPosition;
use Modules\Core\Filament\Resources\TaxResource\Pages\CreateTax as BaseCreateTax;
use Modules\Core\Filament\Clusters\Configuration\Resources\TaxResource;

class CreateTax extends BaseCreateTax
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
