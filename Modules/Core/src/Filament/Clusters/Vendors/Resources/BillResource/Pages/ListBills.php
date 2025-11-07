<?php

namespace Modules\Core\Filament\Clusters\Vendors\Resources\BillResource\Pages;

use Modules\Core\Filament\Resources\BillResource\Pages\ListBills as BaseListBills;
use Modules\Core\Filament\Clusters\Vendors\Resources\BillResource;

class ListBills extends BaseListBills
{
    protected static string $resource = BillResource::class;
}
