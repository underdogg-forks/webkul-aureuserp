<?php

namespace Modules\Core\Filament\Clusters\Reporting\Resources\ByEmployeeResource\Pages;

use Modules\Core\Filament\Clusters\Management\Resources\TimeOffResource\Pages\CreateTimeOff as BaseCreateTimeOff;
use Modules\Core\Filament\Clusters\Reporting\Resources\ByEmployeeResource;

class CreateByEmployee extends BaseCreateTimeOff
{
    protected static string $resource = ByEmployeeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data = parent::mutateFormDataBeforeCreate($data);

        $data['date_from'] = $data['request_date_from'] ?? null;
        $data['date_to']   = $data['request_date_to'] ?? null;

        return $data;
    }
}
