<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\PurchaseOrderResource\Pages;

use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\OrderResource\Pages\ManageReceipts as BaseManageReceipts;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\PurchaseOrderResource;

class ManageReceipts extends BaseManageReceipts
{
    protected static string $resource = PurchaseOrderResource::class;
}
