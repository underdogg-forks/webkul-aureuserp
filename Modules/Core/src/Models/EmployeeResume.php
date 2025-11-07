<?php

namespace Modules\Core\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\User;
class EmployeeResume extends BaseModel
{
    public $timestamps = false;

    protected $casts = [];
    /**
     * protected $fillable = [
     * 'employee_id',
     * 'employee_resume_line_type_id',
     * 'creator_id',
     * 'user_id',
     * 'display_type',
     * 'start_date',
     * 'end_date',
     * 'name',
     * 'description',
     * ];
     */
    protected $guarded = [];

    protected $table = 'employees_employee_resumes';

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

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function resumeType()
    {
        return $this->belongsTo(EmployeeResumeLineType::class, 'employee_resume_line_type_id');
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
