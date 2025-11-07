<?php

namespace Modules\Products\Filament\Clusters\Operations\Resources\DeliveryResource\Pages;

use Modules\Products\Filament\Clusters\Operations\Resources\DeliveryResource;
use Modules\Products\Filament\Clusters\Operations\Resources\OperationResource\Pages\ManageMoves as OperationManageMoves;

class ManageMoves extends OperationManageMoves
{
    protected static string $resource = DeliveryResource::class;
}
