<?php

namespace Modules\Core;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Modules\Core\Package;
use Modules\Core\PackageServiceProvider;

class PluginManagerServiceProvider extends PackageServiceProvider
{
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
}
