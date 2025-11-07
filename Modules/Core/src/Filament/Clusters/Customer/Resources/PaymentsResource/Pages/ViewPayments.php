<?php

namespace Modules\Core\Filament\Clusters\Customer\Resources\PaymentsResource\Pages;

use Modules\Core\Filament\Resources\PaymentsResource\Pages\ViewPayments as BaseViewPayments;
use Modules\Core\Filament\Clusters\Customer\Resources\PaymentsResource;

class ViewPayments extends BaseViewPayments
{
    protected static string $resource = PaymentsResource::class;
}
