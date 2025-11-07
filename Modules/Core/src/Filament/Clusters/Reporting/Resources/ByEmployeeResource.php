<?php

namespace Modules\Core\Filament\Clusters\Reporting\Resources;

use BackedEnum;
use Filament\Tables\Table;
use Modules\Core\Filament\Clusters\Management\Resources\TimeOffResource as BaseByEmployeeResource;
use Modules\Core\Filament\Clusters\Reporting;
use Modules\Core\Filament\Clusters\Reporting\Resources\ByEmployeeResource\Pages\CreateByEmployee;
use Modules\Core\Filament\Clusters\Reporting\Resources\ByEmployeeResource\Pages\EditByEmployee;
use Modules\Core\Filament\Clusters\Reporting\Resources\ByEmployeeResource\Pages\ListByEmployees;
use Modules\Core\Filament\Clusters\Reporting\Resources\ByEmployeeResource\Pages\ViewByEmployee;
use Modules\Core\Models\Leave;

class ByEmployeeResource extends BaseByEmployeeResource
{
    protected static ?string $model = Leave::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static ?string $cluster = Reporting::class;

    public static function getModelLabel(): string
    {
        return __('time-off::filament/clusters/reporting/resources/by-employee.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('time-off::filament/clusters/reporting/resources/by-employee.navigation.title');
    }

    public static function table(Table $table): Table
    {
        return parent::table($table)
            ->defaultGroup('employee.name');
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListByEmployees::route('/'),
            'create' => CreateByEmployee::route('/create'),
            'edit'   => EditByEmployee::route('/{record}/edit'),
            'view'   => ViewByEmployee::route('/{record}'),
        ];
    }
}
