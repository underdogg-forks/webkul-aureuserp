<?php

namespace Modules\Products\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Products\Database\Factories\ProductQuantityFactory;
use Modules\Products\Settings\OperationSettings;
use Modules\Crm\Models\Partner;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;
class ProductQuantity extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    /**
     * Table name.
     *
     * @var string
     */
    protected $casts = [
        'inventory_quantity_set' => 'boolean',
        'scheduled_at'           => 'date',
        'incoming_at'            => 'datetime',
    ];
    /**
     * protected $fillable = [
     * 'quantity',
     * 'reserved_quantity',
     * 'counted_quantity',
     * 'difference_quantity',
     * 'inventory_diff_quantity',
     * 'inventory_quantity_set',
     * 'scheduled_at',
     * 'incoming_at',
     * 'product_id',
     * 'location_id',
     * 'storage_category_id',
     * 'lot_id',
     * 'package_id',
     * 'partner_id',
     * 'user_id',
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
    protected $table = 'inventories_product_quantities';

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

        static::saving(function ($productQuantity) {
            $productQuantity->updateScheduledAt();
        });
    }

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

    public function lot(): BelongsTo
    {
        return $this->belongsTo(Lot::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function storageCategory(): BelongsTo
    {
        return $this->belongsTo(StorageCategory::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    #endregion

    #region Accessors
    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getAvailableQuantityAttribute(): float
    {
        return $this->quantity - $this->reserved_quantity;
    }

    /**
     * Update the scheduled_at attribute.
     */
    public function updateScheduledAt()
    {
        $this->scheduled_at = Carbon::create(
            now()->year,
            app(OperationSettings::class)->annual_inventory_month,
            app(OperationSettings::class)->annual_inventory_day,
            0,
            0,
            0
        );

        if ($this->location?->cyclic_inventory_frequency) {
            $this->scheduled_at = now()->addDays($this->location->cyclic_inventory_frequency);
        }
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

    protected static function newFactory(): ProductQuantityFactory
    {
        return ProductQuantityFactory::new();
    }

    #endregion
}
