<?php

namespace Modules\Core\Filament\Clusters\Configuration\Resources\PaymentTermResource\Pages;

use Modules\Core\Filament\Resources\PaymentTermResource\Pages\ManagePaymentDueTerm as BaseManagePaymentDueTerm;
use Modules\Core\Filament\Clusters\Configuration\Resources\PaymentTermResource;
use Modules\Core\Traits\HasRecordNavigationTabs;

class ManagePaymentDueTerm extends BaseManagePaymentDueTerm
{
    use HasRecordNavigationTabs;

    protected static string $resource = PaymentTermResource::class;
}
