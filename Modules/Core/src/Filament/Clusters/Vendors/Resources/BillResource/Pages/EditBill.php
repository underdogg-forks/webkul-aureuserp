<?php

namespace Modules\Core\Filament\Clusters\Vendors\Resources\BillResource\Pages;

use Modules\Core\Filament\Resources\BillResource\Pages\EditBill as BaseEditBill;
use Modules\Core\Filament\Clusters\Vendors\Resources\BillResource;

class EditBill extends BaseEditBill
{
    protected static string $resource = BillResource::class;
}
