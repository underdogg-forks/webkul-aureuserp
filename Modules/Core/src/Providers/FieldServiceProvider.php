<?php

namespace Modules\Core\Providers;

use Filament\Panel;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\Gate;
use Modules\Core\Models\Field;
use Modules\Core\Policies\FieldPolicy;
use Modules\Core\Package;
use Modules\Core\PackageServiceProvider;
use Modules\Core\Traits\HasFilamentDiscovery;

class FieldServiceProvider extends PackageServiceProvider
{
    use HasFilamentDiscovery;

    public static string $name = 'fields';

    public static string $viewNamespace = 'fields';

    public function configureCustomPackage(Package $package): void
    {
        $package->name(static::$name)
            ->isCore()
            ->hasViews()
            ->hasTranslations()
            ->hasMigrations([
                '2024_11_13_052541_create_custom_fields_table',
            ])
            ->runsMigrations();
    }

    public function packageBooted(): void
    {
        $this->registerCustomCss();

        Gate::policy(Field::class, FieldPolicy::class);
    }

    public function registerCustomCss()
    {
        FilamentAsset::register([
            Css::make('fields', __DIR__ . '/../resources/dist/fields.css'),
        ], 'fields');
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
