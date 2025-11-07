<?php

namespace Modules\Core\Filament\Clusters\Customer\Resources\PaymentsResource\Pages;

use Modules\Core\Filament\Resources\PaymentsResource\Pages\CreatePayments as BaseCreatePayments;
use Modules\Core\Filament\Clusters\Customer\Resources\PaymentsResource;

class CreatePayments extends BaseCreatePayments
{
    protected static string $resource = PaymentsResource::class;

    public function getSubNavigation(): array
    {
        if (filled($cluster = static::getCluster())) {
            return $this->generateNavigationItems($cluster::getClusteredComponents());
        }

        return [];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data = parent::mutateFormDataBeforeCreate($data);

        $data['partner_type'] = 'customer';

        return $data;
    }
}
