<?php

namespace Modules\Core\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Modules\Core\Enums\DisplayType;
use Modules\Core\Enums\MoveState;
use Modules\Core\Models\Product;
use Modules\Crm\Models\Partner;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use Modules\Core\Models\UOM;
class MoveLine extends BaseModel implements Sortable
{
    use HasFactory;

    use SortableTrait;

    public $timestamps = false;

    protected $casts = [
        'parent_state' => MoveState::class,
        'display_type' => DisplayType::class,
    ];
    /**
     * protected $fillable = [
     * 'sort',
     * 'move_id',
     * 'journal_id',
     * 'company_id',
     * 'company_currency_id',
     * 'reconcile_id',
     * 'payment_id',
     * 'tax_repartition_line_id',
     * 'account_id',
     * 'currency_id',
     * 'partner_id',
     * 'group_tax_id',
     * 'tax_line_id',
     * 'tax_group_id',
     * 'statement_id',
     * 'statement_line_id',
     * 'product_id',
     * 'uom_id',
     * 'created_by',
     * 'move_name',
     * 'parent_state',
     * 'reference',
     * 'name',
     * 'matching_number',
     * 'display_type',
     * 'date',
     * 'invoice_date',
     * 'date_maturity',
     * 'discount_date',
     * 'analytic_distribution',
     * 'debit',
     * 'credit',
     * 'balance',
     * 'amount_currency',
     * 'tax_base_amount',
     * 'amount_residual',
     * 'amount_residual_currency',
     * 'quantity',
     * 'price_unit',
     * 'price_subtotal',
     * 'price_total',
     * 'discount',
     * 'discount_amount_currency',
     * 'discount_balance',
     * 'is_imported',
     * 'tax_tag_invert',
     * 'reconciled',
     * 'is_downpayment',
     * 'full_reconcile_id',
     * ];
     */
    protected $guarded = [];

    public $sortable = [
        'order_column_name'  => 'sort',
        'sort_when_creating' => true,
    ];

    protected $table = 'accounts_account_move_lines';

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

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function fullReconcile()
    {
        return $this->belongsTo(FullReconcile::class);
    }

    public function groupTax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function move()
    {
        return $this->belongsTo(Move::class);
    }

    public function moveLines()
    {
        return $this->hasMany(self::class, 'reconcile_id');
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function statement()
    {
        return $this->belongsTo(BankStatement::class);
    }

    public function statementLine()
    {
        return $this->belongsTo(BankStatementLine::class);
    }

    public function taxGroup()
    {
        return $this->belongsTo(TaxGroup::class);
    }

    public function taxes()
    {
        return $this->belongsToMany(Tax::class, 'accounts_accounts_move_line_taxes', 'move_line_id', 'tax_id');
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
