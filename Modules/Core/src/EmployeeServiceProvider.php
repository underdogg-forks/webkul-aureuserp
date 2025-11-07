<?php

namespace Modules\Core;

use Filament\Panel;

use Modules\Core\Console\Commands\InstallCommand;
use Modules\Core\Console\Commands\UninstallCommand;
use Modules\Core\Package;
use Modules\Core\PackageServiceProvider;
use Modules\Core\Traits\HasFilamentDiscovery;

class EmployeeServiceProvider extends PackageServiceProvider
{
    use HasFilamentDiscovery;

    public static string $name = 'employees';

    public function configureCustomPackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasTranslations()
            ->hasMigrations([
                '2024_12_11_045350_create_employees_work_locations_table',
                '2024_12_11_051916_create_employees_departments_table',
                '2024_12_11_054555_create_employees_categories_table',
                '2024_12_11_073130_create_employees_employment_types_table',
                '2024_12_11_075004_create_employees_skill_types_table',
                '2024_12_11_075011_create_employees_skill_levels_table',
                '2024_12_11_075017_create_employees_skills_table',
                '2024_12_11_081046_create_employees_job_positions_table',
                '2024_12_11_100426_create_employees_calendars_table',
                '2024_12_11_100435_create_employees_calendar_attendances_table',
                '2024_12_11_100442_create_employees_calendar_leaves_table',
                '2024_12_11_120605_create_employees_departure_reasons_table',
                '2024_12_12_063353_create_employees_employees_table',
                '2024_12_12_063354_create_employees_employee_skills_table',
                '2024_12_12_140840_create_employees_employee_categories_table',
                '2024_12_16_065746_create_employees_employee_resume_line_types_table',
                '2024_12_16_070029_create_employees_employee_resumes_table',
                '2025_01_08_104443_add_manager_id_to_employees_departments_table',
                '2025_01_15_045708_create_job_position_skills_table',
                '2025_01_24_052852_add_department_id_to_activity_plans_table',
                '2025_08_20_082638_add_unique_user_id_to_employees_employees_table',
            ])
            ->runsMigrations()
            ->hasSeeder('Modules\\Core\\Database\Seeders\\DatabaseSeeder')
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->runsMigrations()
                    ->runsSeeders();
            })
            ->hasUninstallCommand(function (UninstallCommand $command) {})
            ->icon('employees');
    }

    public function packageBooted(): void {}

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
