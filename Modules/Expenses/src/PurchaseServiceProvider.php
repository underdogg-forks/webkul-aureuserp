<?php

namespace Modules\Expenses;

use Filament\Panel;
use Filament\Navigation\NavigationItem;
use Illuminate\Foundation\AliasLoader;
use Livewire\Livewire;
use Modules\Expenses\Facades\PurchaseOrder as PurchaseOrderFacade;
use Modules\Expenses\Livewire\Customer\ListProducts;
use Modules\Expenses\Livewire\Summary;
use Modules\Core\Console\Commands\InstallCommand;
use Modules\Core\Console\Commands\UninstallCommand;
use Modules\Core\Package;
use Modules\Core\PackageServiceProvider;
use Modules\Core\Traits\HasFilamentDiscovery;
use Modules\Expenses\Services\PurchaseOrder;
use Modules\Expenses\Filament\Admin\Clusters\Settings\Pages\ManageProducts;

class PurchaseServiceProvider extends PackageServiceProvider
{
    use HasFilamentDiscovery;

    public static string $name = 'purchases';

    public static string $viewNamespace = 'purchases';

    public function configureCustomPackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasViews()
            ->hasRoute('web')
            ->hasTranslations()
            ->hasMigrations([
                '2025_02_11_101100_create_purchases_order_groups_table',
                '2025_02_11_101101_create_purchases_requisitions_table',
                '2025_02_11_101105_create_purchases_requisition_lines_table',
                '2025_02_11_101110_create_purchases_orders_table',
                '2025_02_11_101118_create_purchases_order_lines_table',
                '2025_02_11_135617_create_purchases_order_line_taxes_table',
                '2025_02_11_142937_create_purchases_order_account_moves_table',
                '2025_02_11_143351_alter_accounts_account_move_lines_table',
                '2025_03_17_101755_add_inventories_columns_to_purchases_orders_table_from_purchases',
                '2025_03_17_101814_add_inventories_columns_to_purchases_order_lines_table_from_purchases',
                '2025_03_17_111610_add_purchases_columns_to_inventories_moves_table_from_purchases',
                '2025_03_17_115707_create_purchases_order_operations_table_from_purchases',
            ])
            ->runsMigrations()
            ->hasSettings([
                '2025_01_11_094022_create_purchases_order_settings',
                '2025_01_11_094022_create_purchases_product_settings',
            ])
            ->runsSettings()
            ->hasDependencies([
                'invoices',
            ])
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->installDependencies()
                    ->runsMigrations();
            })
            ->hasUninstallCommand(function (UninstallCommand $command) {})
            ->icon('purchases');
    }

    public function packageBooted(): void
    {
        Livewire::component('order-summary', Summary::class);

        Livewire::component('list-products', ListProducts::class);

        // \Modules\Core\Models\Move::observe(\Modules\Expenses\Observers\AccountMoveObserver::class);
    }

    public function packageRegistered(): void
    {
        $loader = AliasLoader::getInstance();

        $loader->alias('purchase_order', PurchaseOrderFacade::class);

        $this->app->singleton('purchase_order', PurchaseOrder::class);
    }

    /**
     * Register Filament panel resources
     */
    public function registerFilamentPanel(Panel $panel): void
    {
        if (!Package::isPluginInstalled(static::$name)) {
            return;
        }

        $basePath = $this->getModuleBasePath();
        $namespace = $this->getModuleNamespace();

        $panel->when($panel->getId() === 'customer', function (Panel $panel) use ($basePath, $namespace) {
            $panel
                ->discoverResources(
                    in: $basePath . '/Filament/Customer/Resources',
                    for: $namespace . '\\Filament\\Customer\\Resources'
                )
                ->discoverPages(
                    in: $basePath . '/Filament/Customer/Pages',
                    for: $namespace . '\\Filament\\Customer\\Pages'
                )
                ->discoverClusters(
                    in: $basePath . '/Filament/Customer/Clusters',
                    for: $namespace . '\\Filament\\Customer\\Clusters'
                )
                ->discoverWidgets(
                    in: $basePath . '/Filament/Customer/Widgets',
                    for: $namespace . '\\Filament\\Customer\\Widgets'
                );
        });

        $panel->when($panel->getId() === 'admin', function (Panel $panel) use ($basePath, $namespace) {
            $panel
                ->discoverResources(
                    in: $basePath . '/Filament/Admin/Resources',
                    for: $namespace . '\\Filament\\Admin\\Resources'
                )
                ->discoverPages(
                    in: $basePath . '/Filament/Admin/Pages',
                    for: $namespace . '\\Filament\\Admin\\Pages'
                )
                ->discoverClusters(
                    in: $basePath . '/Filament/Admin/Clusters',
                    for: $namespace . '\\Filament\\Admin\\Clusters'
                )
                ->discoverWidgets(
                    in: $basePath . '/Filament/Admin/Widgets',
                    for: $namespace . '\\Filament\\Admin\\Widgets'
                )
                ->navigationItems([
                    NavigationItem::make('settings')
                        ->label(fn () => __('purchases::app.navigation.settings.label'))
                        ->url(fn () => ManageProducts::getUrl())
                        ->group('Purchase')
                        ->sort(4)
                        ->visible(fn () => ManageProducts::canAccess()),
                ]);
        });
    }
}
