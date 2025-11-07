<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\QuotationResource\Pages;

use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\OrderResource\Pages\EditOrder;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\QuotationResource;

class EditQuotation extends EditOrder
{
    protected static string $resource = QuotationResource::class;
}
