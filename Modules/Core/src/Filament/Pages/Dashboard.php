<?php

namespace Modules\Core\Filament\Pages;

use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Dashboard as BaseDashboard;
use Modules\Core\Filament\Clusters\MyTime;
use Modules\Core\Filament\Widgets\CalendarWidget;
use Modules\Core\Filament\Widgets\MyTimeOffWidget;

class Dashboard extends BaseDashboard
{
    use HasPageShield;

    protected static string $routePath = 'time-off';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $cluster = MyTime::class;

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __('time-off::filament/pages/dashboard.navigation.title');
    }

    public function getWidgets(): array
    {
        return [
            CalendarWidget::class,
        ];
    }

    public function getHeaderWidgets(): array
    {
        return [
            MyTimeOffWidget::make(),
        ];
    }
}
