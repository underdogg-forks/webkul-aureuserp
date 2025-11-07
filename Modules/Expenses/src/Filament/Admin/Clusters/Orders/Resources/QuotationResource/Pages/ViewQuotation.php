<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\QuotationResource\Pages;

use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\OrderResource\Pages\ViewOrder;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\QuotationResource;

class ViewQuotation extends ViewOrder
{
    protected static string $resource = QuotationResource::class;
}
