<?php

namespace Modules\Core;

use Filament\Panel;

use Modules\Core\Console\Commands\InstallCommand;
use Modules\Core\Console\Commands\UninstallCommand;
use Modules\Core\Package;
use Modules\Core\PackageServiceProvider;
use Modules\Core\Traits\HasFilamentDiscovery;

class TimeOffServiceProvider extends PackageServiceProvider
{
    use HasFilamentDiscovery;

    public static string $name = 'time-off';

    public static string $viewNamespace = 'time-off';

    public function configureCustomPackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasTranslations()
            ->hasMigrations([
                '2025_01_17_080711_create_time_off_leave_types_table',
                '2025_01_17_080712_create_time_off_leaves_table',
                '2025_01_20_080058_create_time_off_user_leave_types_table',
                '2025_01_20_130725_create_time_off_leave_mandatory_days_table',
                '2025_01_21_073921_create_time_off_leave_accrual_plans_table',
                '2025_01_21_085833_create_time_off_leave_accrual_levels_table',
                '2025_01_22_101656_create_time_off_leave_allocations_table',
                '2025_08_13_120000_alter_private_name_column_in_time_off_leaves_table',
            ])
            ->hasDependencies([
                'employees',
            ])
            ->runsMigrations()
            ->hasSeeder('Modules\\Core\\Database\\Seeders\\DatabaseSeeder')
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->installDependencies()
                    ->runsMigrations()
                    ->runsSeeders();
            })
            ->hasUninstallCommand(function (UninstallCommand $command) {})
            ->icon('time-offs');
    }

    /**
     * Register Filament panel resources
     */
    public function registerFilamentPanel(Panel $panel): void
    {
        if (!Package::isPluginInstalled(static::$name)) {
            return;
        }

        $panel->when($panel->getId() === 'admin', function (Panel $panel) {
            $basePath = $this->getModuleBasePath();
            $namespace = $this->getModuleNamespace();

            $panel
                ->discoverResources(
                    in: $basePath . '/Filament/Resources',
                    for: $namespace . '\Filament\Resources'
                )
                ->discoverPages(
                    in: $basePath . '/Filament/Pages',
                    for: $namespace . '\Filament\Pages'
                )
                ->discoverClusters(
                    in: $basePath . '/Filament/Clusters',
                    for: $namespace . '\Filament\Clusters'
                )
                ->discoverWidgets(
                    in: $basePath . '/Filament/Widgets',
                    for: $namespace . '\Filament\Widgets'
                );
        });
    }
}
