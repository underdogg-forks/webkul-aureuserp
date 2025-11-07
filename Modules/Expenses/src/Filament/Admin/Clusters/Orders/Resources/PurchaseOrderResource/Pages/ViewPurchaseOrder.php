<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\PurchaseOrderResource\Pages;

use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\OrderResource\Pages\ViewOrder;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\PurchaseOrderResource;

class ViewPurchaseOrder extends ViewOrder
{
    protected static string $resource = PurchaseOrderResource::class;
}
