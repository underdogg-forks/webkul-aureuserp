<?php

namespace Modules\Core\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Core\Database\Factories\PriceRuleItemFactory;
use Modules\Core\Enums\PriceRuleApplyTo;
use Modules\Core\Enums\PriceRuleBase;
use Modules\Core\Enums\PriceRuleType;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
class PriceRuleItem extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    /**
     * Casts.
     *
     * @var string
     */
    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
        'apply_to'  => PriceRuleApplyTo::class,
        'base'      => PriceRuleBase::class,
        'type'      => PriceRuleType::class,
    ];
    /**
     * protected $fillable = [
     * 'apply_to',
     * 'display_apply_to',
     * 'base',
     * 'type',
     * 'min_quantity',
     * 'fixed_price',
     * 'price_discount',
     * 'price_round',
     * 'price_surcharge',
     * 'price_markup',
     * 'price_min_margin',
     * 'percent_price',
     * 'starts_at',
     * 'ends_at',
     * 'price_rule_id',
     * 'base_price_rule_id',
     * 'currency_id',
     * 'product_id',
     * 'category_id',
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
    protected $table = 'products_price_rule_items';

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

    public function basePriceRule(): BelongsTo
    {
        return $this->belongsTo(PriceRule::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
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

    public function priceRule(): BelongsTo
    {
        return $this->belongsTo(PriceRule::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
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

    protected static function newFactory(): PriceRuleItemFactory
    {
        return PriceRuleItemFactory::new();
    }

    #endregion
}
