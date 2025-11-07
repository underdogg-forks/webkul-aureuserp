<?php

namespace Modules\Crm\Filament\Clusters\Configurations\Resources;

use BackedEnum;
use Modules\Crm\Filament\Clusters\Configurations;
use Modules\Crm\Filament\Clusters\Configurations\Resources\BankAccountResource\Pages\ManageBankAccounts;
use Modules\Crm\Filament\Resources\BankAccountResource as BaseBankAccountResource;

class BankAccountResource extends BaseBankAccountResource
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    protected static bool $shouldRegisterNavigation = true;

    protected static ?int $navigationSort = 5;

    protected static ?string $cluster = Configurations::class;

    public static function getNavigationGroup(): string
    {
        return __('contacts::filament/clusters/configurations/resources/bank-account.navigation.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('contacts::filament/clusters/configurations/resources/bank-account.navigation.title');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageBankAccounts::route('/'),
        ];
    }
}
