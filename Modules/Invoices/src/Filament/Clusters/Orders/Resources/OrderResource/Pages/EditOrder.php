<?php

namespace Modules\Invoices\Filament\Clusters\Orders\Resources\OrderResource\Pages;

use Modules\Invoices\Filament\Clusters\Orders\Resources\OrderResource;
use Modules\Invoices\Filament\Clusters\Orders\Resources\QuotationResource\Pages\EditQuotation as BaseEditOrder;

class EditOrder extends BaseEditOrder
{
    protected static string $resource = OrderResource::class;
}
