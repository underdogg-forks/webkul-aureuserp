<?php

namespace Modules\Crm\Filament\Clusters\Configurations\Resources;

use BackedEnum;
use Modules\Crm\Filament\Clusters\Configurations;
use Modules\Crm\Filament\Clusters\Configurations\Resources\BankResource\Pages\ManageBanks;
use Modules\Crm\Filament\Resources\BankResource as BaseBankResource;

class BankResource extends BaseBankResource
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-library';

    protected static bool $shouldRegisterNavigation = true;

    protected static ?int $navigationSort = 4;

    protected static ?string $cluster = Configurations::class;

    public static function getNavigationGroup(): string
    {
        return __('contacts::filament/clusters/configurations/resources/bank.navigation.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('contacts::filament/clusters/configurations/resources/bank.navigation.title');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageBanks::route('/'),
        ];
    }
}
