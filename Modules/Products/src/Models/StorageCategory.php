<?php

namespace Modules\Products\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Modules\Products\Database\Factories\StorageCategoryFactory;
use Modules\Products\Enums\AllowNewProduct;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;
class StorageCategory extends BaseModel implements Sortable
{
    use HasFactory;

    use SortableTrait;

    public $timestamps = false;

    /**
     * Table name.
     *
     * @var string
     */
    protected $casts = [
        'allow_new_products' => AllowNewProduct::class,
    ];
    /**
     * protected $fillable = [
     * 'name',
     * 'sort',
     * 'allow_new_products',
     * 'parent_path',
     * 'max_weight',
     * 'company_id',
     * 'creator_id',
     * ];
     */
    protected $guarded = [];

    public $sortable = [
        'order_column_name'  => 'sort',
        'sort_when_creating' => true,
    ];

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'inventories_storage_categories';

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

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }

    public function storageCategoryCapacities(): HasMany
    {
        return $this->hasMany(StorageCategoryCapacity::class, 'storage_category_id');
    }

    public function storageCategoryCapacitiesByPackageType(): HasMany
    {
        return $this->storageCategoryCapacities()->whereNotNull('package_type_id');
    }

    public function storageCategoryCapacitiesByProduct(): HasMany
    {
        return $this->storageCategoryCapacities()->whereNotNull('product_id');
    }

    #endregion

    #region Accessors
    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

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

    protected static function newFactory(): StorageCategoryFactory
    {
        return StorageCategoryFactory::new();
    }

    #endregion
}
