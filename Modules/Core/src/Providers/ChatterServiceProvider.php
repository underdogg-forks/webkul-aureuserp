<?php

namespace Modules\Core\Providers;

use Filament\Panel;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Livewire\Livewire;
use Modules\Core\Livewire\ChatterHeaderActions;
use Modules\Core\Livewire\ChatterPanel;
use Modules\Core\Package;
use Modules\Core\PackageServiceProvider;
use Modules\Core\Traits\HasFilamentDiscovery;

class ChatterServiceProvider extends PackageServiceProvider
{
    use HasFilamentDiscovery;

    public static string $name = 'chatter';

    public static string $viewNamespace = 'chatter';

    public function configureCustomPackage(Package $package): void
    {
        $package->name(static::$name)
            ->isCore()
            ->hasViews()
            ->hasTranslations()
            ->hasMigrations([
                '2024_12_11_101222_create_chatter_followers_table',
                '2024_12_23_062355_create_chatter_messages_table',
                '2024_12_23_080148_create_chatter_attachments_table',
                '2025_03_12_072356_add_column_is_read_to_chatter_messages_table',
            ])
            ->runsMigrations();
    }

    public function packageBooted(): void
    {
        $this->registerCustomCss();

        Livewire::component('chatter-panel', ChatterPanel::class);
        Livewire::component('chatter-header-actions', ChatterHeaderActions::class);
    }

    public function registerCustomCss()
    {
        FilamentAsset::register([
            Css::make('chatter', __DIR__ . '/../resources/dist/chatter.css'),
        ], 'chatter');
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
