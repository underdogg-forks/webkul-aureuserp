<?php

namespace Modules\Core\Filament\Resources\FiscalPositionResource\Pages;

use BackedEnum;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Resources\Pages\ManageRelatedRecords;
use Modules\Core\Filament\Resources\FiscalPositionResource;
use Modules\Core\Traits\FiscalPositionTax;

class ManageFiscalPositionTax extends ManageRelatedRecords
{
    use FiscalPositionTax;

    protected static string $resource = FiscalPositionResource::class;

    protected static string $relationship = 'fiscalPositionTaxes';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document';

    public static function getSubNavigationPosition(): SubNavigationPosition
    {
        return SubNavigationPosition::Top;
    }

    public static function getNavigationLabel(): string
    {
        return __('accounts::filament/resources/fiscal-position/pages/manage-fiscal-position.navigation.title');
    }
}
