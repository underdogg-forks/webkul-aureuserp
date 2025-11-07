<?php

namespace Modules\Crm\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Crm\Database\Factories\BankAccountFactory;
use Modules\Core\Models\User;
use Modules\Core\Models\Bank;
class BankAccount extends BaseModel
{
    use HasFactory;

    use SoftDeletes;

    public $timestamps = false;

    /**
     * Table name.
     *
     * @var string
     */
    protected $casts = [
        'is_active'      => 'boolean',
        'can_send_money' => 'boolean',
    ];
    /**
     * protected $fillable = [
     * 'account_number',
     * 'account_holder_name',
     * 'is_active',
     * 'can_send_money',
     * 'creator_id',
     * 'partner_id',
     * 'bank_id',
     * ];
     */
    protected $guarded = [];

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'partners_bank_accounts';

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

        static::creating(function ($bankAccount) {
            $bankAccount->account_holder_name = $bankAccount->partner->name;
        });

        static::updating(function ($bankAccount) {
            $bankAccount->account_holder_name = $bankAccount->partner->name;
        });
    }

    #endregion

    #region Relationships
    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
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

    protected static function newFactory(): BankAccountFactory
    {
        return BankAccountFactory::new();
    }

    #endregion
}
