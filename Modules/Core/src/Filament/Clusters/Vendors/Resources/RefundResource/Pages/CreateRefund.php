<?php

namespace Modules\Core\Filament\Clusters\Vendors\Resources\RefundResource\Pages;

use Modules\Core\Filament\Resources\RefundResource\Pages\CreateRefund as BaseCreateRefund;
use Modules\Core\Filament\Clusters\Vendors\Resources\RefundResource;

class CreateRefund extends BaseCreateRefund
{
    protected static string $resource = RefundResource::class;
}
