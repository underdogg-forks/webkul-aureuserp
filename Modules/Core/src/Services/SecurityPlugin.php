<?php

namespace Modules\Core\Services;

use Filament\Contracts\Plugin;
use Filament\Panel;
use ReflectionClass;
use Modules\Core\Settings\UserSettings;

class SecurityPlugin implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'security';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->when($panel->getId() == 'admin', function (Panel $panel) {
                $panel->passwordReset()
                    ->discoverResources(in: $this->getPluginBasePath('/Filament/Resources'), for: 'Modules\\Core\\Filament\\Resources')
                    ->discoverPages(in: $this->getPluginBasePath('/Filament/Pages'), for: 'Modules\\Core\\Filament\\Pages')
                    ->discoverClusters(in: $this->getPluginBasePath('/Filament/Clusters'), for: 'Modules\\Core\\Filament\\Clusters')
                    ->discoverClusters(in: $this->getPluginBasePath('/Filament/Widgets'), for: 'Modules\\Core\\Filament\\Widgets');
            });

        if (
            ! app()->runningInConsole()
            && ! app(UserSettings::class)?->enable_reset_password
        ) {
            $panel->passwordReset(false);
        }
    }

    public function boot(Panel $panel): void {}

    protected function getPluginBasePath($path = null): string
    {
        $reflector = new ReflectionClass(get_class($this));

        return dirname($reflector->getFileName()) . ($path ?? '');
    }
}
