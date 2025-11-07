<?php

namespace Modules\Crm\Filament\Clusters\Configurations\Resources;

use BackedEnum;
use Modules\Crm\Filament\Clusters\Configurations;
use Modules\Crm\Filament\Clusters\Configurations\Resources\IndustryResource\Pages\ManageIndustries;
use Modules\Crm\Filament\Resources\IndustryResource as BaseIndustryResource;

class IndustryResource extends BaseIndustryResource
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-office';

    protected static bool $shouldRegisterNavigation = true;

    protected static ?int $navigationSort = 3;

    protected static ?string $cluster = Configurations::class;

    public static function getNavigationLabel(): string
    {
        return __('contacts::filament/clusters/configurations/resources/industry.navigation.title');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageIndustries::route('/'),
        ];
    }
}
