<?php

namespace Modules\Invoices\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Modules\Core\Models\User;
use Modules\Core\Models\UOM;
class OrderOption extends BaseModel implements Sortable
{
    use SortableTrait;

    public $timestamps = false;

    protected $casts = [];
    /**
     * protected $fillable = [
     * 'sort',
     * 'order_id',
     * 'product_id',
     * 'line_id',
     * 'uom_id',
     * 'creator_id',
     * 'name',
     * 'quantity',
     * 'price_unit',
     * 'discount',
     * ];
     */
    protected $guarded = [];

    public $sortable = [
        'order_column_name'  => 'sort',
        'sort_when_creating' => true,
    ];

    protected $table = 'sales_order_options';

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

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function line()
    {
        return $this->belongsTo(OrderLine::class, 'line_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function uom()
    {
        return $this->belongsTo(UOM::class, 'uom_id');
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

    #endregion
}
