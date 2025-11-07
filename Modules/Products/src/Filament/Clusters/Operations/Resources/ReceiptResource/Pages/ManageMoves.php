<?php

namespace Modules\Products\Filament\Clusters\Operations\Resources\ReceiptResource\Pages;

use Modules\Products\Filament\Clusters\Operations\Resources\OperationResource\Pages\ManageMoves as OperationManageMoves;
use Modules\Products\Filament\Clusters\Operations\Resources\ReceiptResource;

class ManageMoves extends OperationManageMoves
{
    protected static string $resource = ReceiptResource::class;
}
