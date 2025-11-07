<?php

namespace Modules\Core\Filament\Clusters\Configuration\Resources\TaxResource\Pages;

use Modules\Core\Filament\Resources\TaxResource\Pages\ManageDistributionForInvoice as BaseManageDistributionForInvoice;
use Modules\Core\Filament\Clusters\Configuration\Resources\TaxResource;

class ManageDistributionForInvoice extends BaseManageDistributionForInvoice
{
    protected static string $resource = TaxResource::class;
}
