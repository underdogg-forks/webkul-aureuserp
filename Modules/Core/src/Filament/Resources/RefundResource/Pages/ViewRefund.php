<?php

namespace Modules\Core\Filament\Resources\RefundResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;
use Modules\Core\Filament\Resources\InvoiceResource\Actions as BaseActions;
use Modules\Core\Filament\Resources\RefundResource;
use Modules\Core\Filament\Actions as ChatterActions;
use Modules\Core\Traits\HasRecordNavigationTabs;

class ViewRefund extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = RefundResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ChatterActions\ChatterAction::make()
                ->setResource($this->getResource()),
            BaseActions\PayAction::make(),
            BaseActions\CancelAction::make(),
            BaseActions\ConfirmAction::make(),
            BaseActions\ResetToDraftAction::make(),
            BaseActions\SetAsCheckedAction::make(),
            DeleteAction::make(),
        ];
    }
}
