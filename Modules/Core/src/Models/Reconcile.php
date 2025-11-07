<?php

namespace Modules\Core\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;
class Reconcile extends BaseModel implements Sortable
{
    use HasFactory;

    use SortableTrait;

    public $timestamps = false;

    protected $casts = [];
    /**
     * protected $fillable = [
     * 'sort',
     * 'company_id',
     * 'past_months_limit',
     * 'created_by',
     * 'rule_type',
     * 'matching_order',
     * 'counter_part_type',
     * 'match_nature',
     * 'match_amount',
     * 'match_label',
     * 'match_level_parameters',
     * 'match_note',
     * 'match_note_parameters',
     * 'match_transaction_type',
     * 'match_transaction_type_parameters',
     * 'payment_tolerance_type',
     * 'decimal_separator',
     * 'name',
     * 'auto_reconcile',
     * 'to_check',
     * 'match_text_location_label',
     * 'match_text_location_note',
     * 'match_text_location_reference',
     * 'match_same_currency',
     * 'allow_payment_tolerance',
     * 'match_partner',
     * 'match_amount_min',
     * 'match_amount_max',
     * 'payment_tolerance_parameters',
     * ];
     */
    protected $guarded = [];

    public $sortable = [
        'order_column_name'  => 'sort',
        'sort_when_creating' => true,
    ];

    protected $table = 'accounts_reconciles';

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

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
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
