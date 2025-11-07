<?php

namespace Modules\Core\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;
use Modules\Core\Enums\AccruedGainTime;
use Modules\Core\Enums\CarryoverDate;
use Modules\Core\Enums\CarryoverDay;
use Modules\Core\Enums\CarryoverMonth;
class LeaveAccrualPlan extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = [
        'accrued_gain_time' => AccruedGainTime::class,
        'carryover_day'     => CarryoverDay::class,
        'carryover_month'   => CarryoverMonth::class,
        'carryover_date'    => CarryoverDate::class,
    ];
    /**
     * protected $fillable = [
     * 'time_off_type_id',
     * 'company_id',
     * 'carryover_day',
     * 'creator_id',
     * 'name',
     * 'transition_mode',
     * 'accrued_gain_time',
     * 'carryover_date',
     * 'carryover_month',
     * 'added_value_type',
     * 'is_active',
     * 'is_based_on_worked_time',
     * ];
     */
    protected $guarded = [];

    protected $table = 'time_off_leave_accrual_plans';

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

    public function leaveAccrualLevels()
    {
        return $this->hasMany(LeaveAccrualLevel::class, 'accrual_plan_id');
    }

    public function timeOffType()
    {
        return $this->belongsTo(LeaveType::class, 'time_off_type_id');
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
