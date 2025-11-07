<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\QuotationResource\Pages;

use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\OrderResource\Pages\ManageBills as BaseManageBills;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\QuotationResource;

class ManageBills extends BaseManageBills
{
    protected static string $resource = QuotationResource::class;
}
