<?php

namespace Modules\Core\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Database\Factories\WorkLocationFactory;
use Modules\Core\Enums\WorkLocation as WorkLocationEnum;
use Modules\Core\Traits\HasCustomFields;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;
class WorkLocation extends BaseModel
{
    use HasCustomFields;

    use HasFactory;

    use SoftDeletes;

    public $timestamps = false;

    protected $casts = [
        'is_active'     => 'boolean',
        'location_type' => WorkLocationEnum::class,
    ];
    /**
     * protected $fillable = [
     * 'company_id',
     * 'creator_id',
     * 'name',
     * 'location_type',
     * 'location_number',
     * 'is_active',
     * ];
     */
    protected $guarded = [];

    protected $table = 'employees_work_locations';

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

    public function createdBy(): BelongsTo
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

    /**
     * Scope a query to only include active work locations.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

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
    protected static function newFactory(): WorkLocationFactory
    {
        return WorkLocationFactory::new();
    }

    #endregion
}
