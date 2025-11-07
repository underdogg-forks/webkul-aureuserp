<?php

namespace Modules\Core\Filament\Clusters\Vendors\Resources\PaymentsResource\Pages;

use Modules\Core\Filament\Resources\PaymentsResource\Pages\CreatePayments as BaseCreatePayments;
use Modules\Core\Filament\Clusters\Vendors\Resources\PaymentsResource;

class CreatePayments extends BaseCreatePayments
{
    protected static string $resource = PaymentsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data = parent::mutateFormDataBeforeCreate($data);

        $data['partner_type'] = 'supplier';

        return $data;
    }
}
