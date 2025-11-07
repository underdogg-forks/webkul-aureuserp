<?php

namespace Modules\Core\Filament\Clusters\Customer\Resources\InvoiceResource\Pages;

use Modules\Core\Filament\Resources\InvoiceResource\Pages\CreateInvoice as BaseCreateInvoice;
use Modules\Core\Filament\Clusters\Customer\Resources\InvoiceResource;

class CreateInvoice extends BaseCreateInvoice
{
    protected static string $resource = InvoiceResource::class;
}
