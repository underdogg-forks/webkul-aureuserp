<?php

namespace Modules\Invoices\Filament\Clusters\Orders\Resources\OrderResource\Pages;

use Modules\Invoices\Filament\Clusters\Orders\Resources\OrderResource;
use Modules\Invoices\Filament\Clusters\Orders\Resources\QuotationResource\Pages\ManageDeliveries as BaseManageDeliveries;

class ManageDeliveries extends BaseManageDeliveries
{
    protected static string $resource = OrderResource::class;
}
