<?php

namespace Modules\Core\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Database\Factories\EmployeeEmployeeCategoryFactory;
class EmployeeEmployeeCategory extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = [];
    /**
     * protected $fillable = ['employee_id', 'category_id'];
     */
    protected $guarded = [];

    protected $table = 'employees_employee_categories';

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

    /**
     * Relationship to fetch the category (skill).
     */
    public function category()
    {
        return $this->belongsTo(EmployeeCategory::class, 'category_id');
    }

    /**
     * Relationship to fetch the employee.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
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
    protected static function newFactory(): EmployeeEmployeeCategoryFactory
    {
        return EmployeeEmployeeCategoryFactory::new();
    }

    #endregion
}
