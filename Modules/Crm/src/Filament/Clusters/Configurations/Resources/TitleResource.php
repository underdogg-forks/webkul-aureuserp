<?php

namespace Modules\Crm\Filament\Clusters\Configurations\Resources;

use BackedEnum;
use Modules\Crm\Filament\Clusters\Configurations;
use Modules\Crm\Filament\Clusters\Configurations\Resources\TitleResource\Pages\ManageTitles;
use Modules\Crm\Filament\Resources\TitleResource as BaseTitleResource;

class TitleResource extends BaseTitleResource
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';

    protected static bool $shouldRegisterNavigation = true;

    protected static ?int $navigationSort = 2;

    protected static ?string $cluster = Configurations::class;

    public static function getPages(): array
    {
        return [
            'index' => ManageTitles::route('/'),
        ];
    }
}
