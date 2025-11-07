<?php

namespace Modules\Core\Traits;

use Filament\Panel;
use ReflectionClass;
use Modules\Core\Package;

trait HasFilamentDiscovery
{
    /**
     * Register Filament resources for the given panel
     */
    protected function registerFilamentResources(Panel $panel, string $pluginId): void
    {
        if (!Package::isPluginInstalled($pluginId)) {
            return;
        }

        $basePath = $this->getModuleBasePath();

        // Register for admin panel
        if ($panel->getId() === 'admin') {
            $this->discoverAdminResources($panel, $basePath);
        }

        // Register for customer panel
        if ($panel->getId() === 'customer') {
            $this->discoverCustomerResources($panel, $basePath);
        }
    }

    /**
     * Discover resources for admin panel
     */
    protected function discoverAdminResources(Panel $panel, string $basePath): void
    {
        $namespace = $this->getModuleNamespace();
        
        $panel
            ->discoverResources(
                in: $basePath . '/Filament/Admin/Resources',
                for: $namespace . '\\Filament\\Admin\\Resources'
            )
            ->discoverPages(
                in: $basePath . '/Filament/Admin/Pages',
                for: $namespace . '\\Filament\\Admin\\Pages'
            )
            ->discoverClusters(
                in: $basePath . '/Filament/Admin/Clusters',
                for: $namespace . '\\Filament\\Admin\\Clusters'
            )
            ->discoverWidgets(
                in: $basePath . '/Filament/Admin/Widgets',
                for: $namespace . '\\Filament\\Admin\\Widgets'
            );
    }

    /**
     * Discover resources for customer panel
     */
    protected function discoverCustomerResources(Panel $panel, string $basePath): void
    {
        $namespace = $this->getModuleNamespace();
        
        $panel
            ->discoverResources(
                in: $basePath . '/Filament/Customer/Resources',
                for: $namespace . '\\Filament\\Customer\\Resources'
            )
            ->discoverPages(
                in: $basePath . '/Filament/Customer/Pages',
                for: $namespace . '\\Filament\\Customer\\Pages'
            )
            ->discoverClusters(
                in: $basePath . '/Filament/Customer/Clusters',
                for: $namespace . '\\Filament\\Customer\\Clusters'
            )
            ->discoverWidgets(
                in: $basePath . '/Filament/Customer/Widgets',
                for: $namespace . '\\Filament\\Customer\\Widgets'
            );
    }

    /**
     * Discover resources for simple panel structure (no Admin/Customer subdirectories)
     */
    protected function discoverSimpleResources(Panel $panel, string $basePath): void
    {
        $namespace = $this->getModuleNamespace();
        
        $panel
            ->discoverResources(
                in: $basePath . '/Filament/Resources',
                for: $namespace . '\\Filament\\Resources'
            )
            ->discoverPages(
                in: $basePath . '/Filament/Pages',
                for: $namespace . '\\Filament\\Pages'
            )
            ->discoverClusters(
                in: $basePath . '/Filament/Clusters',
                for: $namespace . '\\Filament\\Clusters'
            )
            ->discoverWidgets(
                in: $basePath . '/Filament/Widgets',
                for: $namespace . '\\Filament\\Widgets'
            );
    }

    /**
     * Get the base path of the module
     */
    protected function getModuleBasePath(): string
    {
        $reflector = new ReflectionClass(get_class($this));
        
        return dirname($reflector->getFileName());
    }

    /**
     * Get the namespace of the module
     */
    protected function getModuleNamespace(): string
    {
        $reflector = new ReflectionClass(get_class($this));
        
        return $reflector->getNamespaceName();
    }
}
