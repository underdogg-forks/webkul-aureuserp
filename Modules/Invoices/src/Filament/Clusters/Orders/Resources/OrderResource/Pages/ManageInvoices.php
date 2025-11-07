<?php

namespace Modules\Invoices\Filament\Clusters\Orders\Resources\OrderResource\Pages;

use Modules\Invoices\Filament\Clusters\Orders\Resources\OrderResource;
use Modules\Invoices\Filament\Clusters\Orders\Resources\QuotationResource\Pages\ManageInvoices as BaseManageInvoices;

class ManageInvoices extends BaseManageInvoices
{
    protected static string $resource = OrderResource::class;
}
