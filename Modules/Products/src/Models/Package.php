<?php

namespace Modules\Products\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Modules\Products\Database\Factories\PackageFactory;
use Modules\Products\Enums\PackageUse;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;
class Package extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    /**
     * Table name.
     *
     * @var string
     */
    protected $casts = [
        'package_use' => PackageUse::class,
        'pack_date'   => 'date',
    ];
    /**
     * protected $fillable = [
     * 'name',
     * 'package_use',
     * 'pack_date',
     * 'package_type_id',
     * 'location_id',
     * 'company_id',
     * 'creator_id',
     * ];
     */
    protected $guarded = [];

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'inventories_packages';

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

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function moveLines(): HasMany
    {
        return $this->hasMany(MoveLine::class);
    }

    public function moves(): HasManyThrough
    {
        return $this->hasManyThrough(
            Move::class,
            MoveLine::class,
            'package_id',
            'id',
            'id',
            'move_id'
        );
    }

    public function operations(): HasManyThrough
    {
        return $this->hasManyThrough(
            Operation::class,
            MoveLine::class,
            'result_package_id',
            'id',
            'id',
            'operation_id'
        );
    }

    public function packageType(): BelongsTo
    {
        return $this->belongsTo(PackageType::class);
    }

    public function quantities(): HasMany
    {
        return $this->hasMany(ProductQuantity::class);
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

    protected static function newFactory(): PackageFactory
    {
        return PackageFactory::new();
    }

    #endregion
}
