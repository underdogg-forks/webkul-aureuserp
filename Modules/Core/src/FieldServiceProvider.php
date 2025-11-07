<?php

namespace Modules\Core;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\Gate;
use Modules\Core\Models\Field;
use Modules\Core\Policies\FieldPolicy;
use Modules\Core\Package;
use Modules\Core\PackageServiceProvider;

class FieldServiceProvider extends PackageServiceProvider
{
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
}
