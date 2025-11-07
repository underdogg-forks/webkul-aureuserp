<?php

namespace Modules\Core\Filament\Resources;

use BackedEnum;
use Modules\Core\Filament\Resources\RefundResource\Pages\CreateRefund;
use Modules\Core\Filament\Resources\RefundResource\Pages\EditRefund;
use Modules\Core\Filament\Resources\RefundResource\Pages\ListRefunds;
use Modules\Core\Filament\Resources\RefundResource\Pages\ViewRefund;
use Modules\Core\Models\Move as AccountMove;

class RefundResource extends BillResource
{
    protected static ?string $model = AccountMove::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-credit-card';

    public static function getPages(): array
    {
        return [
            'index'  => ListRefunds::route('/'),
            'create' => CreateRefund::route('/create'),
            'edit'   => EditRefund::route('/{record}/edit'),
            'view'   => ViewRefund::route('/{record}'),
        ];
    }
}
