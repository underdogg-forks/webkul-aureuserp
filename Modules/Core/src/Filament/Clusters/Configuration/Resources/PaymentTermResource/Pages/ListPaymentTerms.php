<?php

namespace Modules\Core\Filament\Clusters\Configuration\Resources\PaymentTermResource\Pages;

use Modules\Core\Filament\Resources\PaymentTermResource\Pages\ListPaymentTerms as BaseListPaymentTerms;
use Modules\Core\Filament\Clusters\Configuration\Resources\PaymentTermResource;

class ListPaymentTerms extends BaseListPaymentTerms
{
    protected static string $resource = PaymentTermResource::class;
}
