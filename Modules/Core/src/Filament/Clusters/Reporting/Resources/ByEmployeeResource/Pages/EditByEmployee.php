<?php

namespace Modules\Core\Filament\Clusters\Reporting\Resources\ByEmployeeResource\Pages;

use Modules\Core\Filament\Clusters\Management\Resources\TimeOffResource\Pages\EditTimeOff as BaseEditTimeOff;
use Modules\Core\Filament\Clusters\Reporting\Resources\ByEmployeeResource;

class EditByEmployee extends BaseEditTimeOff
{
    protected static string $resource = ByEmployeeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
