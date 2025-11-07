<?php

namespace Modules\Core\Filament\Clusters\Vendors\Resources\BillResource\Pages;

use Modules\Core\Filament\Resources\BillResource\Pages\CreateBill as BaseCreateBill;
use Modules\Core\Filament\Clusters\Vendors\Resources\BillResource;

class CreateBill extends BaseCreateBill
{
    protected static string $resource = BillResource::class;
}
