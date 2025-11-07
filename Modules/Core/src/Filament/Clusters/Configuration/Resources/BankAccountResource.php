<?php

namespace Modules\Core\Filament\Clusters\Configuration\Resources;

use Modules\Core\Filament\Resources\BankAccountResource as BaseBankAccountResource;
use Modules\Core\Filament\Clusters\Configuration;
use Modules\Core\Filament\Clusters\Configuration\Resources\BankAccountResource\Pages\ListBankAccounts;
use Modules\Core\Models\BankAccount;

class BankAccountResource extends BaseBankAccountResource
{
    protected static ?string $model = BankAccount::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $cluster = Configuration::class;

    public static function getPages(): array
    {
        return [
            'index' => ListBankAccounts::route('/'),
        ];
    }
}
