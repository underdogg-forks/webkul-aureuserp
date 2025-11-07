<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\QuotationResource\Pages;

use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\OrderResource\Pages\ManageReceipts as BaseManageReceipts;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\QuotationResource;

class ManageReceipts extends BaseManageReceipts
{
    protected static string $resource = QuotationResource::class;
}
