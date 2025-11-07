<?php

namespace Modules\Expenses\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\HasChatter;
use Modules\Core\Traits\HasLogActivity;
use Modules\Core\Traits\HasCustomFields;
use Modules\Crm\Models\Partner;
use Modules\Expenses\Database\Factories\RequisitionFactory;
use Modules\Expenses\Enums\RequisitionState;
use Modules\Expenses\Enums\RequisitionType;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;

class Requisition extends Model
{
    use HasChatter;
    use HasCustomFields;
    use HasFactory;
    use HasLogActivity;
    use SoftDeletes;

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'purchases_requisitions';

    /**
     * Fillable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'state',
        'reference',
        'starts_at',
        'ends_at',
        'description',
        'currency_id',
        'partner_id',
        'user_id',
        'company_id',
        'creator_id',
    ];

    /**
     * Table name.
     *
     * @var string
     */
    protected $casts = [
        'state' => RequisitionState::class,
        'type'  => RequisitionType::class,
    ];

    protected array $logAttributes = [
        'name',
        'type',
        'state',
        'reference',
        'starts_at',
        'ends_at',
        'description',
        'currency.name' => 'Currency',
        'partner.name'  => 'Partner',
        'user.name'     => 'Buyer',
        'company.name'  => 'Company',
        'creator.name'  => 'Creator',
    ];

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lines(): HasMany
    {
        return $this->hasMany(RequisitionLine::class);
    }

    /**
     * Update the full name without triggering additional events.
     */
    public function updateName()
    {
        if ($this->type == RequisitionType::BLANKET_ORDER) {
            $this->name = 'BO/' . $this->id;
        } else {
            $this->name = 'PT/' . $this->id;
        }
    }

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

    protected static function newFactory(): RequisitionFactory
    {
        return RequisitionFactory::new();
    }
}
