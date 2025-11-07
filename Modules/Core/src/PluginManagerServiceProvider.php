<?php

namespace Modules\Core;

use Filament\Panel;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Modules\Core\Package;
use Modules\Core\PackageServiceProvider;
use Modules\Core\Traits\HasFilamentDiscovery;

class PluginManagerServiceProvider extends PackageServiceProvider
{
    use HasFilamentDiscovery;

    public static string $name = 'plugin-manager';

    public static string $viewNamespace = 'plugin-manager';

    public function configureCustomPackage(Package $package): void
    {
        $package->name(static::$name)
            ->isCore()
            ->hasViews()
            ->hasTranslations()
            ->hasSeeder('Modules\\Core\\Database\\Seeders\\PluginSeeder');
    }

    public function packageBooted(): void
    {
        $this->registerCustomCss();
    }

    public function registerCustomCss()
    {
        FilamentAsset::register([
            Css::make('plugins', __DIR__ . '/../resources/dist/plugin.css'),
        ], 'plugins');
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
