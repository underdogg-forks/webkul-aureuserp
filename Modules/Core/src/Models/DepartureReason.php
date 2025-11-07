<?php

namespace Modules\Core\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Modules\Core\Database\Factories\DepartureReasonFactory;
use Modules\Core\Traits\HasCustomFields;
use Modules\Core\Models\User;
class DepartureReason extends BaseModel implements Sortable
{
    use HasCustomFields;

    use HasFactory;

    use SortableTrait;

    public $timestamps = false;

    protected $casts = [];
    /**
     * protected $fillable = [
     * 'sort',
     * 'reason_code',
     * 'creator_id',
     * 'name',
     * ];
     */
    protected $guarded = [];

    public $sortable = [
        'order_column_name'  => 'sort',
        'sort_when_creating' => true,
    ];

    protected $table = 'employees_departure_reasons';

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

    public function employees()
    {
        return $this->hasMany(Employee::class);
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
    protected static function newFactory(): DepartureReasonFactory
    {
        return DepartureReasonFactory::new();
    }

    #endregion
}
