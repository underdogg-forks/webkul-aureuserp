<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Database\Factories\WorkLocationFactory;
use Modules\Core\Enums\WorkLocation as WorkLocationEnum;
use Modules\Core\Traits\HasCustomFields;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;

class WorkLocation extends Model
{
    use HasCustomFields;
    use HasFactory;
    use SoftDeletes;

    protected $table = 'employees_work_locations';

    protected $fillable = [
        'company_id',
        'creator_id',
        'name',
        'location_type',
        'location_number',
        'is_active',
    ];

    protected $casts = [
        'is_active'     => 'boolean',
        'location_type' => WorkLocationEnum::class,
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Scope a query to only include active work locations.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the factory instance for the model.
     */
    protected static function newFactory(): WorkLocationFactory
    {
        return WorkLocationFactory::new();
    }
}
