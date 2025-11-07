<?php

namespace Modules\Core;

use Filament\Contracts\Plugin;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use ReflectionClass;
use Modules\Core\Filament\Clusters\Settings\Pages\Products;
use Modules\Core\Package;

class InvoicePlugin implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'invoices';
    }

    public function register(Panel $panel): void
    {
        if ( ! Package::isPluginInstalled($this->getId())) {
            return;
        }

        $panel
            ->when($panel->getId() == 'admin', function (Panel $panel) {
                $panel->discoverResources(in: $this->getPluginBasePath('/Filament/Resources'), for: 'Modules\\Core\\Filament\\Resources')
                    ->discoverPages(in: $this->getPluginBasePath('/Filament/Pages'), for: 'Modules\\Core\\Filament\\Pages')
                    ->discoverClusters(in: $this->getPluginBasePath('/Filament/Clusters'), for: 'Modules\\Core\\Filament\\Clusters')
                    ->discoverWidgets(in: $this->getPluginBasePath('/Filament/Widgets'), for: 'Modules\\Core\\Filament\\Widgets')
                    ->navigationItems([
                        NavigationItem::make('settings')
                            ->label(fn () => __('invoices::app.navigation.settings.label'))
                            ->url(fn () => Products::getUrl())
                            ->group('Invoices')
                            ->sort(4)
                            ->visible(fn () => Products::canAccess()),
                    ]);
            });
    }

    public function boot(Panel $panel): void {}

    protected function getPluginBasePath($path = null): string
    {
        $reflector = new ReflectionClass(get_class($this));

        return dirname($reflector->getFileName()) . ($path ?? '');
    }
}
