<?php

namespace Modules\Invoices\Settings;

use Spatie\LaravelSettings\Settings;
use Modules\Core\Enums\InvoicePolicy;

class InvoiceSettings extends Settings
{
    public InvoicePolicy $invoice_policy;

    public static function group(): string
    {
        return 'sales_invoicing';
    }
}
