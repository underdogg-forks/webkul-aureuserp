<?php

namespace Modules\Invoices\Filament\Clusters\ToInvoice\Resources\OrderToInvoiceResource\Pages;

use Modules\Invoices\Filament\Clusters\Orders\Resources\QuotationResource\Pages\EditQuotation as BaseEditQuotation;
use Modules\Invoices\Filament\Clusters\ToInvoice\Resources\OrderToInvoiceResource;

class EditOrderToInvoice extends BaseEditQuotation
{
    protected static string $resource = OrderToInvoiceResource::class;
}
