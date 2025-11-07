<?php

namespace Modules\Products\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Core\Traits\HasCustomFields;
use Modules\Products\Enums\LocationType;
use Modules\Products\Enums\ProductTracking;
use Modules\Core\Models\Product as BaseProduct;
use Modules\Core\Models\User;
class Product extends BaseModel
{
    use HasCustomFields;

    public $timestamps = false;

    protected $casts = [];
    /**
     * protected $fillable = [
     * //
     * ];
     */
    protected $guarded = [];

    #region Static Methods
    /*
    |--------------------------------------------------------------------------
    | Static Methods
    |--------------------------------------------------------------------------
    */

    #endregion

    #region Relationships
    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function moveLines(): HasMany
    {
        if ($this->is_configurable) {
            return $this->hasMany(MoveLine::class)
                ->orWhereIn('product_id', $this->variants()->pluck('id'));
        }

        return $this->hasMany(MoveLine::class);
    }

    public function moves(): HasMany
    {
        if ($this->is_configurable) {
            return $this->hasMany(Move::class)
                ->orWhereIn('product_id', $this->variants()->pluck('id'));
        }

        return $this->hasMany(Move::class);
    }

    public function orderPoints(): HasMany
    {
        return $this->hasMany(OrderPoint::class);
    }

    public function quantities(): HasMany
    {
        if ($this->is_configurable) {
            return $this->hasMany(ProductQuantity::class)
                ->orWhereIn('product_id', $this->variants()->pluck('id'));
        }

        return $this->hasMany(ProductQuantity::class);
    }

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function routes(): BelongsToMany
    {
        return $this->belongsToMany(Route::class, 'inventories_product_routes', 'product_id', 'route_id');
    }

    public function storageCategoryCapacities(): BelongsToMany
    {
        return $this->belongsToMany(StorageCategoryCapacity::class, 'inventories_storage_category_capacities', 'storage_category_id', 'package_type_id');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    #endregion

    #region Accessors
    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Create a new Eloquent model instance.
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->mergeFillable([
            'sale_delay',
            'tracking',
            'description_picking',
            'description_pickingout',
            'description_pickingin',
            'is_storable',
            'expiration_time',
            'use_time',
            'removal_time',
            'alert_time',
            'use_expiration_date',
            'responsible_id',
        ]);

        $this->mergeCasts([
            'tracking'            => ProductTracking::class,
            'use_expiration_date' => 'boolean',
            'is_storable'         => 'boolean',
        ]);

        parent::__construct($attributes);
    }

    public function getOnHandQuantityAttribute(): float
    {
        return $this->quantities()
            ->whereHas('location', function ($query) {
                $query->where('type', LocationType::INTERNAL)
                    ->where('is_scrap', false);
            })
            ->sum('quantity');
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
