<?php

namespace Modules\Invoices\Filament\Clusters\ToInvoice\Resources\OrderToInvoiceResource\Pages;

use Modules\Invoices\Filament\Clusters\Orders\Resources\QuotationResource\Pages\ViewQuotation as BaseViewQuotation;
use Modules\Invoices\Filament\Clusters\ToInvoice\Resources\OrderToInvoiceResource;

class ViewOrderToInvoice extends BaseViewQuotation
{
    protected static string $resource = OrderToInvoiceResource::class;
}
