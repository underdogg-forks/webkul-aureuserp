<?php

namespace Modules\Core;

use Filament\Contracts\Plugin;
use Filament\Panel;
use ReflectionClass;

class ChatterPlugin implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'chatter';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->discoverResources(in: $this->getPluginBasePath('/Filament/Resources'), for: 'Modules\\Core\\Filament\\Resources')
            ->discoverPages(in: $this->getPluginBasePath('/Filament/Pages'), for: 'Modules\\Core\\Filament\\Pages')
            ->discoverClusters(in: $this->getPluginBasePath('/Filament/Clusters'), for: 'Modules\\Core\\Filament\\Clusters')
            ->discoverClusters(in: $this->getPluginBasePath('/Filament/Widgets'), for: 'Modules\\Core\\Filament\\Widgets');
    }

    public function boot(Panel $panel): void {}

    protected function getPluginBasePath($path = null): string
    {
        $reflector = new ReflectionClass(get_class($this));

        return dirname($reflector->getFileName()) . ($path ?? '');
    }
}
