<?php

namespace Modules\Products\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Products\Database\Factories\LotFactory;
use Modules\Products\Enums\LocationType;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;
use Modules\Core\Models\UOM;
class Lot extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    /**
     * Table name.
     *
     * @var string
     */
    protected $casts = [
        'properties'      => 'array',
        'expiry_reminded' => 'boolean',
        'expiration_date' => 'datetime',
        'use_date'        => 'datetime',
        'removal_date'    => 'datetime',
        'alert_date'      => 'datetime',
    ];
    /**
     * protected $fillable = [
     * 'name',
     * 'description',
     * 'reference',
     * 'properties',
     * 'expiry_reminded',
     * 'expiration_date',
     * 'use_date',
     * 'removal_date',
     * 'alert_date',
     * 'product_id',
     * 'uom_id',
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
    protected $table = 'inventories_lots';

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

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function quantities(): HasMany
    {
        return $this->hasMany(ProductQuantity::class);
    }

    public function uom(): BelongsTo
    {
        return $this->belongsTo(UOM::class);
    }

    #endregion

    #region Accessors
    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getTotalQuantityAttribute()
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

    protected static function newFactory(): LotFactory
    {
        return LotFactory::new();
    }

    #endregion
}
