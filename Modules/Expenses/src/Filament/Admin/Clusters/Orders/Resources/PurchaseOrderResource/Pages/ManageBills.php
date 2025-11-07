<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\PurchaseOrderResource\Pages;

use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\OrderResource\Pages\ManageBills as BaseManageBills;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\PurchaseOrderResource;

class ManageBills extends BaseManageBills
{
    protected static string $resource = PurchaseOrderResource::class;
}
