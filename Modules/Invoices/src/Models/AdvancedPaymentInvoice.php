<?php

namespace Modules\Invoices\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
class AdvancedPaymentInvoice extends BaseModel
{
    public $timestamps = false;

    protected $casts = [];
    /**
     * protected $fillable = [
     * 'currency_id',
     * 'company_id',
     * 'creator_id',
     * 'advance_payment_method',
     * 'fixed_amount',
     * 'deduct_down_payments',
     * 'consolidated_billing',
     * 'amount',
     * ];
     */
    protected $guarded = [];

    protected $table = 'sales_advance_payment_invoices';

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

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'sales_advance_payment_invoice_order_sales', 'advance_payment_invoice_id', 'order_id');
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
