<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\QuotationResource\Pages;

use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\OrderResource\Pages\CreateOrder;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\QuotationResource;

class CreateQuotation extends CreateOrder
{
    protected static string $resource = QuotationResource::class;
}
