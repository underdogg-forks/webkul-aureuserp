<?php

namespace Modules\Core\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Database\Factories\CalendarFactory;
use Modules\Core\Traits\HasCustomFields;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;
class Calendar extends BaseModel
{
    use HasCustomFields;

    use HasFactory;

    use SoftDeletes;

    public $timestamps = false;

    protected $casts = [];
    /**
     * protected $fillable = [
     * 'name',
     * 'timezone',
     * 'hours_per_day',
     * 'is_active',
     * 'two_weeks_calendar',
     * 'flexible_hours',
     * 'full_time_required_hours',
     * 'creator_id',
     * 'company_id',
     * ];
     */
    protected $guarded = [];

    protected $table = 'employees_calendars';

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

    public function attendance()
    {
        return $this->hasMany(CalendarAttendance::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'creator_id');
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

    /**
     * Get the factory instance for the model.
     */
    protected static function newFactory(): CalendarFactory
    {
        return CalendarFactory::new();
    }

    #endregion
}
