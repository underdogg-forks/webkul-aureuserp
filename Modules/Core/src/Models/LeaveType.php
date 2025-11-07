<?php

namespace Modules\Core\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;
use Modules\Core\Enums\LeaveValidationType;
class LeaveType extends BaseModel implements Sortable
{
    use HasFactory;

    use SoftDeletes;

    use SortableTrait;

    public $timestamps = false;

    protected $casts = [
        'leave_validation_type' => LeaveValidationType::class,
    ];
    /**
     * protected $fillable = [
     * 'sort',
     * 'color',
     * 'company_id',
     * 'max_allowed_negative',
     * 'creator_id',
     * 'leave_validation_type',
     * 'requires_allocation',
     * 'employee_requests',
     * 'allocation_validation_type',
     * 'time_type',
     * 'request_unit',
     * 'name',
     * 'create_calendar_meeting',
     * 'is_active',
     * 'show_on_dashboard',
     * 'unpaid',
     * 'include_public_holidays_in_duration',
     * 'support_document',
     * 'allows_negative',
     * ];
     */
    protected $guarded = [];

    public $sortable = [
        'order_column_name'  => 'sort',
        'sort_when_creating' => true,
    ];

    protected $table = 'time_off_leave_types';

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
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function notifiedTimeOffOfficers()
    {
        return $this->belongsToMany(User::class, 'time_off_user_leave_types', 'leave_type_id', 'user_id');
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
