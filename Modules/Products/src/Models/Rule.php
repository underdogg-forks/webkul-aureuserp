<?php

namespace Modules\Products\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Modules\Products\Database\Factories\RuleFactory;
use Modules\Products\Enums\GroupPropagation;
use Modules\Products\Enums\ProcureMethod;
use Modules\Products\Enums\RuleAction;
use Modules\Products\Enums\RuleAuto;
use Modules\Crm\Models\Partner;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;
class Rule extends BaseModel implements Sortable
{
    use HasFactory;

    use SoftDeletes;

    use SortableTrait;

    public $timestamps = false;

    /**
     * Table name.
     *
     * @var string
     */
    protected $casts = [
        'action'                   => RuleAction::class,
        'group_propagation_option' => GroupPropagation::class,
        'auto'                     => RuleAuto::class,
        'procure_method'           => ProcureMethod::class,
        'location_dest_from_rule'  => 'boolean',
        'propagate_cancel'         => 'boolean',
        'propagate_carrier'        => 'boolean',
    ];
    /**
     * protected $fillable = [
     * 'sort',
     * 'name',
     * 'route_sort',
     * 'delay',
     * 'group_propagation_option',
     * 'action',
     * 'procure_method',
     * 'auto',
     * 'push_domain',
     * 'location_dest_from_rule',
     * 'propagate_cancel',
     * 'propagate_carrier',
     * 'source_location_id',
     * 'destination_location_id',
     * 'route_id',
     * 'operation_type_id',
     * 'partner_address_id',
     * 'warehouse_id',
     * 'propagate_warehouse_id',
     * 'company_id',
     * 'creator_id',
     * 'deleted_at',
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
    protected $table = 'inventories_rules';

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

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function destinationLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function operationType(): BelongsTo
    {
        return $this->belongsTo(OperationType::class);
    }

    public function partnerAddress(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function propagateWarehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    public function sourceLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
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

    protected static function newFactory(): RuleFactory
    {
        return RuleFactory::new();
    }

    #endregion
}
