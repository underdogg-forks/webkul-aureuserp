<?php

namespace Modules\Core\Providers;

use Filament\Panel;

use Modules\Core\Package;
use Modules\Core\PackageServiceProvider;
use Modules\Core\Traits\HasFilamentDiscovery;

class SecurityServiceProvider extends PackageServiceProvider
{
    use HasFilamentDiscovery;

    public static string $name = 'security';

    public static string $viewNamespace = 'security';

    public function configureCustomPackage(Package $package): void
    {
        $package->name(static::$name)
            ->isCore()
            ->hasViews()
            ->hasTranslations()
            ->hasRoute('web')
            ->runsMigrations()
            ->hasMigrations([
                '2024_11_11_112529_create_user_invitations_table',
                '2024_11_12_125715_create_teams_table',
                '2024_11_12_130019_create_user_team_table',
                '2024_12_10_101127_add_default_company_id_column_to_users_table',
                '2024_12_13_130906_add_partner_id_to_users_table',
                '2025_08_21_082229_alter_roles_table',
                '2025_08_21_101646_alter_users_table',
            ])
            ->hasSettings([
                '2024_11_05_042358_create_user_settings',
                '2025_07_29_064223_create_currency_settings',
            ])
            ->runsSettings();
    }

    public function packageBooted(): void
    {
        $this->app->singleton(PermissionRegistrar::class);
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
