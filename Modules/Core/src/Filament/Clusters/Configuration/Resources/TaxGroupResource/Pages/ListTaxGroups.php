<?php

namespace Modules\Core\Filament\Clusters\Configuration\Resources\TaxGroupResource\Pages;

use Modules\Core\Filament\Resources\TaxGroupResource\Pages\ListTaxGroups as BaseListTaxGroups;
use Modules\Core\Filament\Clusters\Configuration\Resources\TaxGroupResource;

class ListTaxGroups extends BaseListTaxGroups
{
    protected static string $resource = TaxGroupResource::class;
}
