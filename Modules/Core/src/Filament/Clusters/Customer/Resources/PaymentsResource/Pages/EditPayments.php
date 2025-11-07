<?php

namespace Modules\Core\Filament\Clusters\Customer\Resources\PaymentsResource\Pages;

use Modules\Core\Filament\Resources\PaymentsResource\Pages\EditPayments as BaseEditPayments;
use Modules\Core\Filament\Clusters\Customer\Resources\PaymentsResource;

class EditPayments extends BaseEditPayments
{
    protected static string $resource = PaymentsResource::class;
}
