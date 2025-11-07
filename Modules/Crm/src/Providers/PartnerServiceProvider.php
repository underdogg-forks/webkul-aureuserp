<?php

namespace Modules\Crm\Providers;

use Filament\Panel;

use Modules\Core\Package;
use Modules\Core\PackageServiceProvider;
use Modules\Core\Traits\HasFilamentDiscovery;

class PartnerServiceProvider extends PackageServiceProvider
{
    use HasFilamentDiscovery;

    public static string $name = 'partners';

    public function configureCustomPackage(Package $package): void
    {
        $package->name(static::$name)
            ->isCore()
            ->hasTranslations()
            ->hasMigrations([
                '2024_12_11_101127_create_partners_industries_table',
                '2024_12_11_101127_create_partners_titles_table',
                '2024_12_11_101220_create_partners_partners_table',
                '2024_12_11_101420_create_partners_bank_accounts_table',
                '2024_12_11_101927_create_partners_tags_table',
                '2024_12_11_111929_create_partners_partner_tag_table',
                '2025_03_28_115218_add_address_columns_in_partners_partners_table',
            ])
            ->runsMigrations();
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
