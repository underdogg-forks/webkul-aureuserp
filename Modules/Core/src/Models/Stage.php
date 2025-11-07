<?php

namespace Modules\Core\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Modules\Core\Models\EmployeeJobPosition;
use Modules\Core\Models\User;
class Stage extends BaseModel implements Sortable
{
    use HasFactory;

    use SortableTrait;

    public $timestamps = false;

    protected $casts = [
        'is_default'  => 'boolean',
        'hired_stage' => 'boolean',
        'fold'        => 'boolean',
    ];
    /**
     * protected $fillable = [
     * 'sort',
     * 'is_default',
     * 'creator_id',
     * 'name',
     * 'legend_blocked',
     * 'legend_done',
     * 'legend_normal',
     * 'requirements',
     * 'fold',
     * 'hired_stage',
     * ];
     */
    protected $guarded = [];

    public $sortable = [
        'order_column_name'  => 'sort',
        'sort_when_creating' => true,
    ];

    protected $table = 'recruitments_stages';

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

    public function jobs()
    {
        return $this->belongsToMany(EmployeeJobPosition::class, 'recruitments_stages_jobs', 'stage_id', 'job_id');
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
