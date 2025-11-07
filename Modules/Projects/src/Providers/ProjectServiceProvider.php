<?php

namespace Modules\Projects\Providers;

use Filament\Panel;
use Filament\Navigation\NavigationItem;
use Modules\Core\Console\Commands\InstallCommand;
use Modules\Core\Console\Commands\UninstallCommand;
use Modules\Core\Package;
use Modules\Core\PackageServiceProvider;
use Modules\Core\Traits\HasFilamentDiscovery;
use Modules\Projects\Filament\Clusters\Settings\Pages\ManageTasks;

class ProjectServiceProvider extends PackageServiceProvider
{
    use HasFilamentDiscovery;

    public static string $name = 'projects';

    public function configureCustomPackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasTranslations()
            ->hasMigrations([
                '2024_12_12_074920_create_projects_project_stages_table',
                '2024_12_12_074929_create_projects_projects_table',
                '2024_12_12_074930_create_projects_milestones_table',
                '2024_12_12_100227_create_projects_user_project_favorites_table',
                '2024_12_12_100230_create_projects_tags_table',
                '2024_12_12_100232_create_projects_project_tag_table',
                '2024_12_12_101340_create_projects_task_stages_table',
                '2024_12_12_101344_create_projects_tasks_table',
                '2024_12_12_101350_create_projects_task_users_table',
                '2024_12_12_101352_create_projects_task_tag_table',
                '2024_12_18_145142_add_columns_to_analytic_records_table',
                '2025_09_24_062711_remove_tags_column_from_projects_tasks_table',
            ])
            ->runsMigrations()
            ->hasSettings([
                '2024_12_16_094021_create_project_task_settings',
                '2024_12_16_094021_create_project_time_settings',
            ])
            ->runsSettings()
            ->hasSeeder('Modules\\Projects\\Database\Seeders\\DatabaseSeeder')
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->runsMigrations()
                    ->runsSeeders();
            })
            ->hasUninstallCommand(function (UninstallCommand $command) {})
            ->icon('projects');
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
                    for: $namespace . '\\Filament\\Resources'
                )
                ->discoverPages(
                    in: $basePath . '/Filament/Pages',
                    for: $namespace . '\\Filament\\Pages'
                )
                ->discoverClusters(
                    in: $basePath . '/Filament/Clusters',
                    for: $namespace . '\\Filament\\Clusters'
                )
                ->discoverWidgets(
                    in: $basePath . '/Filament/Widgets',
                    for: $namespace . '\\Filament\\Widgets'
                )
                ->navigationItems([
                    NavigationItem::make('settings')
                        ->label(fn () => __('projects::app.navigation.settings.label'))
                        ->url(fn () => ManageTasks::getUrl())
                        ->group('Project')
                        ->sort(3)
                        ->visible(fn () => ManageTasks::canAccess()),
                ]);
        });
    }
}
