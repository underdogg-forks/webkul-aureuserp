<?php

namespace Modules\Core;

use Filament\Contracts\Plugin;
use Filament\Panel;
use ReflectionClass;
use Modules\Core\Package;

class BlogPlugin implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'blogs';
    }

    public function register(Panel $panel): void
    {
        if ( ! Package::isPluginInstalled($this->getId())) {
            return;
        }

        $panel
            ->when($panel->getId() == 'customer', function (Panel $panel) {
                $panel
                    ->discoverResources(in: $this->getPluginBasePath('/Filament/Customer/Resources'), for: 'Modules\\Core\\Filament\\Customer\\Resources')
                    ->discoverPages(in: $this->getPluginBasePath('/Filament/Customer/Pages'), for: 'Modules\\Core\\Filament\\Customer\\Pages')
                    ->discoverClusters(in: $this->getPluginBasePath('/Filament/Customer/Clusters'), for: 'Modules\\Core\\Filament\\Customer\\Clusters')
                    ->discoverClusters(in: $this->getPluginBasePath('/Filament/Customer/Widgets'), for: 'Modules\\Core\\Filament\\Customer\\Widgets');
            })
            ->when($panel->getId() == 'admin', function (Panel $panel) {
                $panel
                    ->discoverResources(in: $this->getPluginBasePath('/Filament/Admin/Resources'), for: 'Modules\\Core\\Filament\\Admin\\Resources')
                    ->discoverPages(in: $this->getPluginBasePath('/Filament/Admin/Pages'), for: 'Modules\\Core\\Filament\\Admin\\Pages')
                    ->discoverClusters(in: $this->getPluginBasePath('/Filament/Admin/Clusters'), for: 'Modules\\Core\\Filament\\Admin\\Clusters')
                    ->discoverClusters(in: $this->getPluginBasePath('/Filament/Admin/Widgets'), for: 'Modules\\Core\\Filament\\Admin\\Widgets');
            });
    }

    public function boot(Panel $panel): void {}

    protected function getPluginBasePath($path = null): string
    {
        $reflector = new ReflectionClass(get_class($this));

        return dirname($reflector->getFileName()) . ($path ?? '');
    }
}
