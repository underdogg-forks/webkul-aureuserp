<?php

namespace Modules\Products\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Products\Database\Factories\LocationFactory;
use Modules\Products\Enums\LocationType;
use Modules\Core\Enums\ProductRemoval;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;
class Location extends BaseModel
{
    use HasFactory;

    use SoftDeletes;

    public $timestamps = false;

    /**
     * Table name.
     *
     * @var string
     */
    protected $casts = [
        'type'                => LocationType::class,
        'removal_strategy'    => ProductRemoval::class,
        'last_inventory_date' => 'date',
        'next_inventory_date' => 'date',
        'is_scrap'            => 'boolean',
        'is_replenish'        => 'boolean',
        'is_dock'             => 'boolean',
    ];
    /**
     * protected $fillable = [
     * 'position_x',
     * 'position_y',
     * 'position_z',
     * 'type',
     * 'name',
     * 'full_name',
     * 'description',
     * 'parent_path',
     * 'barcode',
     * 'removal_strategy',
     * 'cyclic_inventory_frequency',
     * 'last_inventory_date',
     * 'next_inventory_date',
     * 'is_scrap',
     * 'is_replenish',
     * 'is_dock',
     * 'parent_id',
     * 'storage_category_id',
     * 'warehouse_id',
     * 'company_id',
     * 'creator_id',
     * 'deleted_at',
     * ];
     */
    protected $guarded = [];

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'inventories_locations';

    #region Static Methods
    /*
    |--------------------------------------------------------------------------
    | Static Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Bootstrap any application services.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($category) {
            $category->updateParentPath();

            $category->updateFullName();
        });

        static::updated(function ($category) {
            $category->updateChildrenParentPaths();

            if ($category->wasChanged('full_name')) {
                $category->updateChildrenFullNames();
            }
        });
    }

    #endregion

    #region Relationships
    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class);
    }

    public function storageCategory(): BelongsTo
    {
        return $this->belongsTo(StorageCategory::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class)->withTrashed();
    }

    #endregion

    #region Accessors
    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getIsStockLocationAttribute(): bool
    {
        if ( ! $this->warehouse_id) {
            return false;
        }

        return $this->warehouse->lot_stock_location_id == $this->id
            || ($this->parent_id && $this->parent->is_stock_location);
    }

    public function shouldBypassReservation(): bool
    {
        return in_array($this->type, [
            LocationType::SUPPLIER,
            LocationType::CUSTOMER,
            LocationType::INVENTORY,
            LocationType::PRODUCTION,
        ]) || $this->is_scrap;
    }

    /**
     * Update the full name without triggering additional events.
     */
    public function updateFullName()
    {
        if ($this->type === LocationType::VIEW) {
            $this->full_name = $this->name;
        } else {
            $this->full_name = $this->parent
                ? $this->parent->full_name . '/' . $this->name
                : $this->name;
        }
    }

    /**
     * Update the full name without triggering additional events.
     */
    public function updateParentPath()
    {
        if ($this->type === LocationType::VIEW) {
            $this->parent_path = $this->id . '/';
        } else {
            $this->parent_path = $this->parent
                ? $this->parent->parent_path . $this->id . '/'
                : $this->id . '/';
        }
    }

    public function updateChildrenFullNames(): void
    {
        $children = $this->children()->getModel()
            ->withTrashed()
            ->where('parent_id', $this->id)
            ->get();

        $children->each(function ($child) {
            $child->updateFullName();
            $child->saveQuietly();

            $child->updateChildrenFullNames();
        });
    }

    public function updateChildrenParentPaths(): void
    {
        $children = $this->children()->getModel()
            ->withTrashed()
            ->where('parent_id', $this->id)
            ->get();

        $children->each(function ($child) {
            $child->updateParentPath();
            $child->saveQuietly();

            $child->updateChildrenParentPaths();
        });
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

    protected static function newFactory(): LocationFactory
    {
        return LocationFactory::new();
    }

    #endregion
}
