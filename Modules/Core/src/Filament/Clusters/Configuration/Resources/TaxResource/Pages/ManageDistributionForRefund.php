<?php

namespace Modules\Core\Filament\Clusters\Configuration\Resources\TaxResource\Pages;

use Modules\Core\Filament\Resources\TaxResource\Pages\ManageDistributionForRefund as BaseManageDistributionForRefund;
use Modules\Core\Filament\Clusters\Configuration\Resources\TaxResource;

class ManageDistributionForRefund extends BaseManageDistributionForRefund
{
    protected static string $resource = TaxResource::class;
}
