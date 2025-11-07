<?php

namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Core';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'core';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'database/migrations'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        
        // Register the original plugin service providers
        $this->app->register(\Webkul\Account\AccountServiceProvider::class);
        $this->app->register(\Webkul\Analytic\AnalyticServiceProvider::class);
        $this->app->register(\Webkul\Blog\BlogServiceProvider::class);
        $this->app->register(\Webkul\Chatter\ChatterServiceProvider::class);
        $this->app->register(\Webkul\Employee\EmployeeServiceProvider::class);
        $this->app->register(\Webkul\Field\FieldServiceProvider::class);
        $this->app->register(\Webkul\FullCalendar\FullCalendarServiceProvider::class);
        $this->app->register(\Webkul\Invoice\InvoiceServiceProvider::class);
        $this->app->register(\Webkul\Payment\PaymentServiceProvider::class);
        $this->app->register(\Webkul\PluginManager\PluginManagerServiceProvider::class);
        $this->app->register(\Webkul\Product\ProductServiceProvider::class);
        $this->app->register(\Webkul\Recruitment\RecruitmentServiceProvider::class);
        $this->app->register(\Webkul\Security\SecurityServiceProvider::class);
        $this->app->register(\Webkul\Support\SupportServiceProvider::class);
        $this->app->register(\Webkul\TableViews\TableViewsServiceProvider::class);
        $this->app->register(\Webkul\TimeOff\TimeOffServiceProvider::class);
        $this->app->register(\Webkul\Website\WebsiteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'resources/lang'), $this->moduleNameLower);
            $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'resources/lang'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
