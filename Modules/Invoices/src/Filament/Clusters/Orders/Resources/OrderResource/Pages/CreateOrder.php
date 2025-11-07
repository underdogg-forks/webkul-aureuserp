<?php

namespace Modules\Invoices\Filament\Clusters\Orders\Resources\OrderResource\Pages;

use Modules\Invoices\Filament\Clusters\Orders\Resources\OrderResource;
use Modules\Invoices\Filament\Clusters\Orders\Resources\QuotationResource\Pages\CreateQuotation as BaseCreateOrders;

class CreateOrder extends BaseCreateOrders
{
    protected static string $resource = OrderResource::class;
}
