<?php

namespace Modules\Core\Filament\Clusters\Configuration\Resources\PaymentTermResource\Pages;

use Modules\Core\Filament\Resources\PaymentTermResource\Pages\ViewPaymentTerm as BaseViewPaymentTerm;
use Modules\Core\Filament\Clusters\Configuration\Resources\PaymentTermResource;
use Modules\Core\Traits\HasRecordNavigationTabs;

class ViewPaymentTerm extends BaseViewPaymentTerm
{
    use HasRecordNavigationTabs;

    protected static string $resource = PaymentTermResource::class;
}
