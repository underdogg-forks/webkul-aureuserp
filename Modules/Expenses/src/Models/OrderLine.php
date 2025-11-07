<?php

namespace Modules\Expenses\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Modules\Core\Models\Tax;
use Modules\Products\Models\Location;
use Modules\Products\Models\Move as InventoryMove;
use Modules\Products\Models\OrderPoint;
use Modules\Crm\Models\Partner;
use Modules\Core\Models\Packaging;
use Modules\Expenses\Database\Factories\OrderLineFactory;
use Modules\Expenses\Enums\QtyReceivedMethod;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use Modules\Core\Models\UOM;
class OrderLine extends BaseModel implements Sortable
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
        'qty_received_method' => QtyReceivedMethod::class,
        'planned_at'          => 'datetime',
        'is_downpayment'      => 'boolean',
        'propagate_cancel'    => 'boolean',
    ];
    /**
     * protected $fillable = [
     * 'name',
     * 'state',
     * 'sort',
     * 'qty_received_method',
     * 'display_type',
     * 'product_qty',
     * 'product_uom_qty',
     * 'product_packaging_qty',
     * 'price_tax',
     * 'discount',
     * 'price_unit',
     * 'price_subtotal',
     * 'price_total',
     * 'qty_invoiced',
     * 'qty_received',
     * 'qty_received_manual',
     * 'qty_to_invoice',
     * 'is_downpayment',
     * 'planned_at',
     * 'product_description_variants',
     * 'propagate_cancel',
     * 'price_total_cc',
     * 'uom_id',
     * 'product_id',
     * 'product_packaging_id',
     * 'order_id',
     * 'partner_id',
     * 'currency_id',
     * 'company_id',
     * 'creator_id',
     * 'final_location_id',
     * 'order_point_id',
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
    protected $table = 'purchases_order_lines';

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

    public function accountMoveLines(): HasMany
    {
        return $this->hasMany(AccountMoveLine::class, 'purchase_order_line_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function finalLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'final_location_id');
    }

    public function inventoryMoves(): HasMany
    {
        return $this->hasMany(InventoryMove::class, 'purchase_order_line_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function orderPoint(): BelongsTo
    {
        return $this->belongsTo(OrderPoint::class, 'order_point_id');
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function productPackaging(): BelongsTo
    {
        return $this->belongsTo(Packaging::class);
    }

    public function taxes(): BelongsToMany
    {
        return $this->belongsToMany(Tax::class, 'purchases_order_line_taxes', 'order_line_id', 'tax_id');
    }

    public function uom(): BelongsTo
    {
        return $this->belongsTo(UOM::class);
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

    protected static function newFactory(): OrderLineFactory
    {
        return OrderLineFactory::new();
    }

    #endregion
}
