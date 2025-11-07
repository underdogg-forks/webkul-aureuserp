<?php

namespace Modules\Payments\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Models\Partner;
use Modules\Core\Models\BankAccount;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use Modules\Core\Models\Journal;
use Modules\Core\Models\Account;
use Modules\Core\Models\MoveLine;
class PaymentRegister extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = [];
    /**
     * protected $fillable = [
     * 'currency_id',
     * 'journal_id',
     * 'partner_bank_id',
     * 'custom_user_currency_id',
     * 'source_currency_id',
     * 'company_id',
     * 'partner_id',
     * 'payment_method_line_id',
     * 'writeoff_account_id',
     * 'creator_id',
     * 'communication',
     * 'installments_mode',
     * 'payment_type',
     * 'partner_type',
     * 'payment_difference_handling',
     * 'writeoff_label',
     * 'payment_date',
     * 'amount',
     * 'custom_user_amount',
     * 'source_amount',
     * 'source_amount_currency',
     * 'group_payment',
     * 'can_group_payments',
     * 'payment_token_id',
     * ];
     */
    protected $guarded = [];

    protected $table = 'accounts_payment_registers';

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
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function customUserCurrency()
    {
        return $this->belongsTo(Currency::class, 'custom_user_currency_id');
    }

    public function journal()
    {
        return $this->belongsTo(Journal::class, 'journal_id');
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    public function partnerBank()
    {
        return $this->belongsTo(BankAccount::class, 'partner_bank_id');
    }

    public function paymentMethodLine()
    {
        return $this->belongsTo(PaymentMethodLine::class, 'payment_method_line_id');
    }

    public function registerMoveLines()
    {
        return $this->belongsToMany(MoveLine::class, 'accounts_account_payment_register_move_lines', 'payment_register_id', 'move_line_id');
    }

    public function sourceCurrency()
    {
        return $this->belongsTo(Currency::class, 'source_currency_id');
    }

    public function writeoffAccount()
    {
        return $this->belongsTo(Account::class, 'writeoff_account_id');
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
