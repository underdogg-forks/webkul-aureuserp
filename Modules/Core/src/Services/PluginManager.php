<?php

namespace Modules\Core\Services;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Illuminate\Support\Facades\File;

class PluginManager implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }

    public function getId(): string
    {
        return 'plugin-manager';
    }

    public function register(Panel $panel): void
    {
        $serviceProviders = $this->getServiceProviders();

        foreach ($serviceProviders as $serviceProviderClass) {
            // Get the service provider instance from the container
            $serviceProvider = app($serviceProviderClass);
            
            // Check if the service provider has the registerFilamentPanel method
            if (method_exists($serviceProvider, 'registerFilamentPanel')) {
                $serviceProvider->registerFilamentPanel($panel);
            }
        }
    }

    public function boot(Panel $panel): void {}

    /**
     * Get all module service providers that should register Filament resources
     */
    protected function getServiceProviders(): array
    {
        $serviceProviders = [];
        $modulesPath = base_path('Modules');

        if (!File::exists($modulesPath)) {
            return $serviceProviders;
        }

        // Get all module directories
        $modules = File::directories($modulesPath);

        foreach ($modules as $modulePath) {
            $moduleName = basename($modulePath);
            $providersPath = $modulePath . '/src/Providers';

            if (!File::exists($providersPath)) {
                continue;
            }

            // Look for *ServiceProvider.php files in the src/Providers directory
            $files = File::glob($providersPath . '/*ServiceProvider.php');

            foreach ($files as $file) {
                $className = basename($file, '.php');
                $serviceProviderClass = "Modules\\{$moduleName}\\Providers\\{$className}";

                if (class_exists($serviceProviderClass)) {
                    $serviceProviders[] = $serviceProviderClass;
                }
            }
        }

        return $serviceProviders;
    }
}
