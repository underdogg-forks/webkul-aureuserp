<?php

namespace Modules\Invoices\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;
use Modules\Core\Models\UOM;
class OrderTemplateProduct extends BaseModel
{
    public $timestamps = false;

    protected $casts = [];
    /**
     * protected $fillable = [
     * 'order_template_id',
     * 'company_id',
     * 'product_id',
     * 'product_uom_id',
     * 'creator_id',
     * 'name',
     * 'quantity',
     * 'display_type',
     * ];
     */
    protected $guarded = [];

    protected $table = 'sales_order_template_products';

    #region Static Methods
    /*
    |--------------------------------------------------------------------------
    | Static Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Bootstrap the model and its traits.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($orderTemplateProduct) {
            $orderTemplateProduct->company_id ??= Company::first()?->id;
            $orderTemplateProduct->product_id ??= Product::first()?->id;
            $orderTemplateProduct->product_uom_id ??= UOM::first()?->id;
            $orderTemplateProduct->creator_id ??= User::first()?->id;
        });
    }

    #endregion

    #region Relationships
    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function orderTemplate()
    {
        return $this->belongsTo(OrderTemplate::class, 'order_template_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function uom()
    {
        return $this->belongsTo(UOM::class, 'product_uom_id');
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
