<?php

namespace Modules\Core\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Core\Traits\HasChatter;
use Modules\Core\Traits\HasLogActivity;
use Modules\Core\Models\Calendar;
use Modules\Core\Models\Department;
use Modules\Core\Models\Employee;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;
use Modules\Core\Enums\RequestDateFromPeriod;
use Modules\Core\Enums\State;
class Leave extends BaseModel
{
    use HasChatter;

    use HasFactory;

    use HasLogActivity;

    public $timestamps = false;

    protected $casts = [
        'state'                    => State::class,
        'request_date_from_period' => RequestDateFromPeriod::class,
    ];
    /**
     * protected $fillable = [
     * 'user_id',
     * 'manager_id',
     * 'holiday_status_id',
     * 'employee_id',
     * 'employee_company_id',
     * 'company_id',
     * 'department_id',
     * 'calendar_id',
     * 'meeting_id',
     * 'first_approver_id',
     * 'second_approver_id',
     * 'creator_id',
     * 'private_name',
     * 'attachment',
     * 'state',
     * 'duration_display',
     * 'request_date_from_period',
     * 'request_date_from',
     * 'request_date_to',
     * 'notes',
     * 'request_unit_half',
     * 'request_unit_hours',
     * 'date_from',
     * 'date_to',
     * 'number_of_days',
     * 'number_of_hours',
     * 'request_hour_from',
     * 'request_hour_to',
     * ];
     */
    protected $guarded = [];

    protected $table = 'time_off_leaves';

    protected array $logAttributes = [
        'user.name'                => 'User',
        'manger.name'              => 'Manager',
        'holidayStatus.name'       => 'Holiday Status',
        'employee.name'            => 'Employee',
        'employeeCompany.name'     => 'Employee Company',
        'department.name'          => 'Department',
        'calendar.name'            => 'Calendar',
        'firstApprover.name'       => 'First Approver',
        'lastApprover.name'        => 'Last Approver',
        'private_name'             => 'Description',
        'state'                    => 'State',
        'duration_display'         => 'Duration Display',
        'request_date_from_period' => 'Request Date From Period',
        'request_date_from'        => 'Request Date From',
        'request_date_to'          => 'Request Date To',
        'notes'                    => 'Notes',
        'request_unit_half'        => 'Request Unit Half',
        'request_unit_hours'       => 'Request Unit Hours',
        'date_from'                => 'Date From',
        'date_to'                  => 'Date To',
        'number_of_days'           => 'Number Of Days',
        'number_of_hours'          => 'Number Of Hours',
        'request_hour_from'        => 'Request Hour From',
        'request_hour_to'          => 'Request Hour To',
    ];

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

    public function calendar(): BelongsTo
    {
        return $this->belongsTo(Calendar::class, 'calendar_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function employeeCompany(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'employee_company_id');
    }

    public function firstApprover(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'first_approver_id');
    }

    public function holidayStatus(): BelongsTo
    {
        return $this->belongsTo(LeaveType::class, 'holiday_status_id');
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    public function secondApprover(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'second_approver_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
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
