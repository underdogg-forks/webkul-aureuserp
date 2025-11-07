<?php

namespace Modules\Payments;

use Filament\Panel;

use Modules\Core\Console\Commands\InstallCommand;
use Modules\Core\Console\Commands\UninstallCommand;
use Modules\Core\Package;
use Modules\Core\PackageServiceProvider;
use Modules\Core\Traits\HasFilamentDiscovery;

class PaymentServiceProvider extends PackageServiceProvider
{
    use HasFilamentDiscovery;

    public static string $name = 'payments';

    public function configureCustomPackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasTranslations()
            ->hasMigrations([
                '2025_02_10_131418_create_payments_payment_methods_table',
                '2025_02_11_101123_create_payments_payment_tokens_table',
                '2025_02_11_103602_create_payments_payment_transactions_table',
                '2025_02_12_103602_add_columns_to_account_payments_table',
            ])
            ->runsMigrations()
            ->hasDependencies([
                'accounts',
            ])
            ->hasSeeder('Modules\\Payments\\Database\Seeders\\DatabaseSeeder')
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->installDependencies()
                    ->runsMigrations()
                    ->runsSeeders();
            })
            ->hasUninstallCommand(function (UninstallCommand $command) {});
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
