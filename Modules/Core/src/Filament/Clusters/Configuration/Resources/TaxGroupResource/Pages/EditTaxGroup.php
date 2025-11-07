<?php

namespace Modules\Core\Filament\Clusters\Configuration\Resources\TaxGroupResource\Pages;

use Modules\Core\Filament\Resources\TaxGroupResource\Pages\EditTaxGroup as BaseEditTaxGroup;
use Modules\Core\Filament\Clusters\Configuration\Resources\TaxGroupResource;

class EditTaxGroup extends BaseEditTaxGroup
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
