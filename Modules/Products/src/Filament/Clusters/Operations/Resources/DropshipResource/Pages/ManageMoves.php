<?php

namespace Modules\Products\Filament\Clusters\Operations\Resources\DropshipResource\Pages;

use Modules\Products\Filament\Clusters\Operations\Resources\DropshipResource;
use Modules\Products\Filament\Clusters\Operations\Resources\OperationResource\Pages\ManageMoves as OperationManageMoves;

class ManageMoves extends OperationManageMoves
{
    protected static string $resource = DropshipResource::class;
}
