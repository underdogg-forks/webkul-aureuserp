<?php

namespace Modules\Core\Filament\Clusters\Configuration\Resources\PaymentTermResource\Pages;

use Modules\Core\Filament\Resources\PaymentTermResource\Pages\CreatePaymentTerm as BaseCreatePaymentTerm;
use Modules\Core\Filament\Clusters\Configuration\Resources\PaymentTermResource;

class CreatePaymentTerm extends BaseCreatePaymentTerm
{
    protected static string $resource = PaymentTermResource::class;

    public function getSubNavigation(): array
    {
        if (filled($cluster = static::getCluster())) {
            return $this->generateNavigationItems($cluster::getClusteredComponents());
        }

        return [];
    }
}
