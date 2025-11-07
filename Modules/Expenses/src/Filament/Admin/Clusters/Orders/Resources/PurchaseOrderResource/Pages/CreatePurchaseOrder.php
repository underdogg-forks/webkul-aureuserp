<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\PurchaseOrderResource\Pages;

use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\OrderResource\Pages\CreateOrder;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\PurchaseOrderResource;

class CreatePurchaseOrder extends CreateOrder
{
    protected static string $resource = PurchaseOrderResource::class;
}
