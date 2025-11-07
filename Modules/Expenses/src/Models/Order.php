<?php

namespace Modules\Expenses\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Core\Models\FiscalPosition;
use Modules\Core\Models\Incoterm;
use Modules\Core\Models\Partner;
use Modules\Core\Models\PaymentTerm;
use Modules\Core\Models\Message;
use Modules\Core\Traits\HasChatter;
use Modules\Core\Traits\HasLogActivity;
use Modules\Core\Traits\HasCustomFields;
use Modules\Products\Models\Operation;
use Modules\Products\Models\OperationType;
use Modules\Expenses\Database\Factories\OrderFactory;
use Modules\Expenses\Enums\OrderInvoiceStatus;
use Modules\Expenses\Enums\OrderReceiptStatus;
use Modules\Expenses\Enums\OrderState;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
class Order extends BaseModel
{
    use HasChatter;

    use HasCustomFields;

    use HasFactory;

    use HasLogActivity;

    public $timestamps = false;

    /**
     * Table name.
     *
     * @var string
     */
    protected $casts = [
        'state'                    => OrderState::class,
        'invoice_status'           => OrderInvoiceStatus::class,
        'receipt_status'           => OrderReceiptStatus::class,
        'mail_reminder_confirmed'  => 'boolean',
        'mail_reception_confirmed' => 'boolean',
        'mail_reception_declined'  => 'boolean',
        'report_grids'             => 'boolean',
        'ordered_at'               => 'datetime',
        'approved_at'              => 'datetime',
        'planned_at'               => 'datetime',
        'calendar_start_at'        => 'datetime',
        'effective_date'           => 'datetime',
    ];
    /**
     * protected $fillable = [
     * 'name',
     * 'description',
     * 'priority',
     * 'origin',
     * 'partner_reference',
     * 'state',
     * 'invoice_status',
     * 'receipt_status',
     * 'untaxed_amount',
     * 'tax_amount',
     * 'total_amount',
     * 'total_cc_amount',
     * 'currency_rate',
     * 'mail_reminder_confirmed',
     * 'mail_reception_confirmed',
     * 'mail_reception_declined',
     * 'invoice_count',
     * 'ordered_at',
     * 'approved_at',
     * 'planned_at',
     * 'calendar_start_at',
     * 'incoterm_location',
     * 'effective_date',
     * 'report_grids',
     * 'requisition_id',
     * 'purchases_group_id',
     * 'partner_id',
     * 'currency_id',
     * 'fiscal_position_id',
     * 'payment_term_id',
     * 'incoterm_id',
     * 'user_id',
     * 'company_id',
     * 'creator_id',
     * 'operation_type_id',
     * ];
     */
    protected $guarded = [];

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'purchases_orders';

    protected array $logAttributes = [
        'name',
        'description',
        'priority',
        'origin',
        'partner_reference',
        'state',
        'invoice_status',
        'receipt_status',
        'untaxed_amount',
        'currency_rate',
        'ordered_at',
        'approved_at',
        'planned_at',
        'calendar_start_at',
        'incoterm_location',
        'effective_date',
        'requisition.name' => 'Requisition',
        'partner.name'     => 'Vendor',
        'currency.name'    => 'Currency',
        'fiscalPosition'   => 'Fiscal Position',
        'paymentTerm.name' => 'Payment Term',
        'incoterm.name'    => 'Buyer',
        'user.name'        => 'Buyer',
        'company.name'     => 'Company',
        'creator.name'     => 'Creator',
    ];

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

        static::saving(function ($order) {
            $order->updateName();
        });

        static::created(function ($order) {
            $order->update(['name' => $order->name]);
        });
    }

    #endregion

    #region Relationships
    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function accountMoves(): BelongsToMany
    {
        return $this->belongsToMany(AccountMove::class, 'purchases_order_account_moves', 'order_id', 'move_id');
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

    public function fiscalPosition(): BelongsTo
    {
        return $this->belongsTo(FiscalPosition::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(OrderGroup::class);
    }

    public function incoterm(): BelongsTo
    {
        return $this->belongsTo(Incoterm::class);
    }

    public function lines(): HasMany
    {
        return $this->hasMany(OrderLine::class, 'order_id');
    }

    public function operationType(): BelongsTo
    {
        return $this->belongsTo(OperationType::class, 'operation_type_id');
    }

    public function operations(): BelongsToMany
    {
        return $this->belongsToMany(Operation::class, 'purchases_order_operations', 'purchase_order_id', 'inventory_operation_id');
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function paymentTerm(): BelongsTo
    {
        return $this->belongsTo(PaymentTerm::class);
    }

    public function requisition(): BelongsTo
    {
        return $this->belongsTo(Requisition::class);
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

    /**
     * Checks if new invoice is allow or not.
     */
    public function getQtyToInvoiceAttribute()
    {
        return $this->lines->sum('qty_to_invoice');
    }

    /**
     * Add a new message.
     */
    public function addMessage(array $data): Message
    {
        $message = new Message();

        $user = filament()->auth()->user();

        $message->fill(array_merge([
            'creator_id'       => $user?->id,
            'date_deadline'    => $data['date_deadline'] ?? now(),
            'company_id'       => $data['company_id'] ?? ($user->defaultCompany?->id ?? null),
            'messageable_type' => self::class,
            'messageable_id'   => $this->id,
        ], $data));

        $message->save();

        return $message;
    }

    /**
     * Update the full name without triggering additional events.
     */
    public function updateName()
    {
        $this->name = 'PO/' . $this->id;
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

    protected static function newFactory(): OrderFactory
    {
        return OrderFactory::new();
    }

    #endregion
}
