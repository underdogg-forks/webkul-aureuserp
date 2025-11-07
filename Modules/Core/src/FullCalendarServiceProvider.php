<?php

namespace Modules\Core;

use Filament\Panel;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Modules\Core\Console\Commands\InstallCommand;
use Modules\Core\Console\Commands\UninstallCommand;
use Modules\Core\Package;
use Modules\Core\PackageServiceProvider;
use Modules\Core\Traits\HasFilamentDiscovery;

class FullCalendarServiceProvider extends PackageServiceProvider
{
    use HasFilamentDiscovery;

    public static string $name = 'full-calendar';

    public static string $viewNamespace = 'full-calendar';

    public function configureCustomPackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasViews()
            ->hasTranslations()
            ->hasInstallCommand(function (InstallCommand $command) {})
            ->hasUninstallCommand(function (UninstallCommand $command) {});
    }

    public function packageBooted(): void
    {
        $this->registerCustomCss();
    }

    public function registerCustomCss()
    {
        FilamentAsset::register(assets: [
            Css::make('full-calendar', __DIR__ . '/../resources/dist/app.css'),
            AlpineComponent::make('full-calendar', __DIR__ . '/../resources/dist/app.js'),
        ], package: 'full-calendar');
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
