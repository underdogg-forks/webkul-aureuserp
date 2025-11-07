<?php

namespace Modules\Core\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
class Plugin extends BaseModel implements Sortable
{
    use SortableTrait;

    public $timestamps = false;

    protected $casts = [
        'is_active' => 'boolean',
    ];
    /**
     * protected $fillable = [
     * 'name',
     * 'author',
     * 'summary',
     * 'description',
     * 'latest_version',
     * 'license',
     * 'is_active',
     * 'is_installed',
     * 'sort',
     * ];
     */
    protected $guarded = [];

    public $sortable = [
        'order_column_name'  => 'sort',
        'sort_when_creating' => true,
    ];

    #region Static Methods
    /*
    |--------------------------------------------------------------------------
    | Static Methods
    |--------------------------------------------------------------------------
    */

    protected static function getAllPluginPackages(): array
    {
        $pluginClasses = require base_path('bootstrap/plugins.php');
        $packages      = [];

        foreach ($pluginClasses as $pluginClass) {
            if (class_exists($pluginClass)) {
                $pluginInstance = new $pluginClass();
                $pluginName     = $pluginInstance->getId();

                $serviceProviderClass = str_replace('Plugin', 'ServiceProvider', $pluginClass);

                if (class_exists($serviceProviderClass)) {
                    $serviceProvider = new $serviceProviderClass(app());
                    $package         = new \Modules\Core\Package();
                    $serviceProvider->configureCustomPackage($package);
                    $packages[$pluginName] = $package;
                }
            }
        }

        return $packages;
    }

    #endregion

    #region Relationships
    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function dependencies(): BelongsToMany
    {
        return $this->belongsToMany(
            self::class,
            'plugin_dependencies',
            'plugin_id',
            'dependency_id'
        );
    }

    public function dependents(): BelongsToMany
    {
        return $this->belongsToMany(
            self::class,
            'plugin_dependencies',
            'dependency_id',
            'plugin_id'
        );
    }

    #endregion

    #region Accessors
    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getServiceProviderClass(): ?string
    {
        $pluginClasses = require base_path('bootstrap/plugins.php');

        foreach ($pluginClasses as $pluginClass) {
            if (class_exists($pluginClass)) {
                $pluginInstance = new $pluginClass();
                if ($pluginInstance->getId() === $this->name) {
                    return str_replace('Plugin', 'ServiceProvider', $pluginClass);
                }
            }
        }

        return null;
    }

    public function getPackage(): ?\Modules\Core\Package
    {
        $packages = self::getAllPluginPackages();

        return $packages[$this->name] ?? null;
    }

    public function getDependenciesFromConfig(): array
    {
        $package = $this->getPackage();

        return $package ? $package->dependencies : [];
    }

    public function getDependentsFromConfig(): array
    {
        $packages   = self::getAllPluginPackages();
        $dependents = [];

        foreach ($packages as $pluginName => $package) {
            if ($pluginName !== $this->name && in_array($this->name, $package->dependencies)) {
                $dependents[] = $pluginName;
            }
        }

        return $dependents;
    }

    #endregion

    #region Mutators
    /*
    |--------------------------------------------------------------------------
    | Mutators
    |--------------------------------------------------------------------------
    */

    #endregion

    #region Scopes
    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    #endregion

    #region Factory
    /*
    |--------------------------------------------------------------------------
    | Factory
    |--------------------------------------------------------------------------
    */

    #endregion
}
