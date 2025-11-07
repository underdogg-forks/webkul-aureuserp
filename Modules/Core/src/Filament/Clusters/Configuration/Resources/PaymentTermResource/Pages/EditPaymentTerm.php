<?php

namespace Modules\Core\Filament\Clusters\Configuration\Resources\PaymentTermResource\Pages;

use Modules\Core\Filament\Resources\PaymentTermResource\Pages\EditPaymentTerm as BaseEditPaymentTerm;
use Modules\Core\Filament\Clusters\Configuration\Resources\PaymentTermResource;
use Modules\Core\Traits\HasRecordNavigationTabs;

class EditPaymentTerm extends BaseEditPaymentTerm
{
    use HasRecordNavigationTabs;

    protected static string $resource = PaymentTermResource::class;
}
