<?php

namespace Modules\Core\Filament\Clusters\Configurations\Resources;

use Modules\Core\Filament\Clusters\Configurations\Resources\EmploymentTypeResource as BaseEmploymentTypeResource;
use Modules\Core\Filament\Clusters\Configurations;
use Modules\Core\Filament\Clusters\Configurations\Resources\EmploymentTypeResource\Pages\ListEmploymentTypes;
use Modules\Core\Models\EmploymentType;

class EmploymentTypeResource extends BaseEmploymentTypeResource
{
    protected static ?string $model = EmploymentType::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $cluster = Configurations::class;

    public static function getNavigationGroup(): string
    {
        return __('recruitments::filament/clusters/configurations/resources/employment-type.navigation.group');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEmploymentTypes::route('/'),
        ];
    }
}
