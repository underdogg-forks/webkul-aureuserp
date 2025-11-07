<?php

namespace Modules\Core\Filament\Clusters\Configuration\Resources\TaxResource\Pages;

use Modules\Core\Filament\Resources\TaxResource\Pages\ListTaxes as BaseListTaxes;
use Modules\Core\Filament\Clusters\Configuration\Resources\TaxResource;

class ListTaxes extends BaseListTaxes
{
    protected static string $resource = TaxResource::class;
}
