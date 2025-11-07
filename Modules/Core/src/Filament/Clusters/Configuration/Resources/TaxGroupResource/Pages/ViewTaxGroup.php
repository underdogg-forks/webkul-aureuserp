<?php

namespace Modules\Core\Filament\Clusters\Configuration\Resources\TaxGroupResource\Pages;

use Modules\Core\Filament\Resources\TaxGroupResource\Pages\ViewTaxGroup as BaseViewTaxGroup;
use Modules\Core\Filament\Clusters\Configuration\Resources\TaxGroupResource;

class ViewTaxGroup extends BaseViewTaxGroup
{
    protected static string $resource = TaxGroupResource::class;

    public function getSubNavigation(): array
    {
        if (filled($cluster = static::getCluster())) {
            return $this->generateNavigationItems($cluster::getClusteredComponents());
        }

        return [];
    }
}
