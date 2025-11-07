<?php

namespace Modules\Core\Filament\Clusters\Configurations\Resources;

use BackedEnum;
use Modules\Core\Filament\Resources\ActivityTypeResource as BaseActivityTypeResource;
use Modules\Core\Filament\Clusters\Configurations;
use Modules\Core\Filament\Clusters\Configurations\Resources\ActivityTypeResource\Pages\CreateActivityType;
use Modules\Core\Filament\Clusters\Configurations\Resources\ActivityTypeResource\Pages\EditActivityType;
use Modules\Core\Filament\Clusters\Configurations\Resources\ActivityTypeResource\Pages\ListActivityTypes;
use Modules\Core\Filament\Clusters\Configurations\Resources\ActivityTypeResource\Pages\ViewActivityType;
use Modules\Core\Models\ActivityType;

class ActivityTypeResource extends BaseActivityTypeResource
{
    protected static ?string $model = ActivityType::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clock';

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $cluster = Configurations::class;

    protected static ?string $pluginName = 'time-off';

    protected static ?int $navigationSort = 5;

    public static function getPages(): array
    {
        return [
            'index'  => ListActivityTypes::route('/'),
            'create' => CreateActivityType::route('/create'),
            'edit'   => EditActivityType::route('/{record}/edit'),
            'view'   => ViewActivityType::route('/{record}'),
        ];
    }
}
