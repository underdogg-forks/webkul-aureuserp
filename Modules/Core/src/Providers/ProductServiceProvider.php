<?php

namespace Modules\Core\Providers;

use Filament\Panel;
use Modules\Core\Console\Commands\InstallCommand;
use Modules\Core\Console\Commands\UninstallCommand;
use Modules\Core\Package;
use Modules\Core\PackageServiceProvider;
use Modules\Core\Traits\HasFilamentDiscovery;

class ProductServiceProvider extends PackageServiceProvider
{
    use HasFilamentDiscovery;

    public static string $name = 'products';

    public static string $viewNamespace = 'products';

    public function configureCustomPackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasViews()
            ->hasTranslations()
            ->hasMigrations([
                '2025_01_05_063925_create_products_categories_table',
                '2025_01_05_100751_create_products_products_table',
                '2025_01_05_100830_create_products_tags_table',
                '2025_01_05_100832_create_products_product_tag_table',
                '2025_01_05_104456_create_products_attributes_table',
                '2025_01_05_104512_create_products_attribute_options_table',
                '2025_01_05_104759_create_products_product_attributes_table',
                '2025_01_05_104809_create_products_product_attribute_values_table',
                '2025_01_05_105626_create_products_packagings_table',
                '2025_01_05_113357_create_products_price_rules_table',
                '2025_01_05_113402_create_products_price_rule_items_table',
                '2025_01_05_123412_create_products_product_suppliers_table',
                '2025_02_18_112837_create_products_product_price_lists_table',
                '2025_02_21_053249 _create_products_product_combinations_table',
                '2025_07_28_080116_alter_products_products_table',
            ])
            ->hasSeeder('Modules\\Core\\Database\Seeders\\DatabaseSeeder')
            ->runsMigrations()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->runsMigrations()
                    ->runsSeeders();
            })
            ->hasUninstallCommand(function (UninstallCommand $command) {});
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
                );
        });
    }
}
