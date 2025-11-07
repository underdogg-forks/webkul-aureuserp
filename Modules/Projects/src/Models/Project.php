<?php

namespace Modules\Projects\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Modules\Core\Traits\HasChatter;
use Modules\Core\Traits\HasLogActivity;
use Modules\Core\Traits\HasCustomFields;
use Modules\Crm\Models\Partner;
use Modules\Projects\Database\Factories\ProjectFactory;
use Modules\Projects\Enums\ProjectStage as ProjectStageEnum;
use Modules\Core\Models\Scopes\UserPermissionScope;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;
class Project extends BaseModel implements Sortable
{
    use HasChatter;

    use HasCustomFields;

    use HasFactory;

    use HasLogActivity;

    use SoftDeletes;

    use SortableTrait;

    public $timestamps = false;

    /**
     * Table name.
     *
     * @var string
     */
    protected $casts = [
        'start_date'              => 'date',
        'end_date'                => 'date',
        'is_active'               => 'boolean',
        'allow_timesheets'        => 'boolean',
        'allow_milestones'        => 'boolean',
        'allow_task_dependencies' => 'boolean',
        'stage'                   => ProjectStageEnum::class,
    ];
    /**
     * protected $fillable = [
     * 'name',
     * 'tasks_label',
     * 'description',
     * 'visibility',
     * 'color',
     * 'sort',
     * 'start_date',
     * 'end_date',
     * 'allocated_hours',
     * 'allow_timesheets',
     * 'allow_milestones',
     * 'allow_task_dependencies',
     * 'is_active',
     * 'stage',
     * 'partner_id',
     * 'company_id',
     * 'user_id',
     * 'creator_id',
     * ];
     */
    protected $guarded = [];

    public $sortable = [
        'order_column_name'  => 'sort',
        'sort_when_creating' => true,
    ];

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'projects_projects';

    protected array $logAttributes = [
        'name',
        'tasks_label',
        'description',
        'visibility',
        'color',
        'sort',
        'start_date',
        'end_date',
        'allocated_hours',
        'allow_timesheets',
        'allow_milestones',
        'allow_task_dependencies',
        'is_active',
        'stage'        => 'Stage',
        'partner.name' => 'Customer',
        'company.name' => 'Company',
        'user.name'    => 'Project Manager',
        'creator.name' => 'Creator',
    ];

    #region Static Methods
    /*
    |--------------------------------------------------------------------------
    | Static Methods
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        static::addGlobalScope(new UserPermissionScope('user'));
    }

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

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function favoriteUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'projects_user_project_favorites', 'project_id', 'user_id');
    }

    public function milestones(): HasMany
    {
        return $this->hasMany(Milestone::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'projects_project_tag', 'project_id', 'tag_id');
    }

    public function taskStages(): HasMany
    {
        return $this->hasMany(TaskStage::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    #endregion

    #region Accessors
    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getIsFavoriteByUserAttribute(): bool
    {
        if ($this->relationLoaded('favoriteUsers')) {
            return $this->favoriteUsers->contains('id', Auth::id());
        }

        return $this->favoriteUsers()->where('user_id', Auth::id())->exists();
    }

    public function getRemainingHoursAttribute(): float
    {
        return $this->allocated_hours - $this->tasks->sum('remaining_hours');
    }

    /**
     * Get the user's first name.
     */
    protected function plannedDate(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['start_date'] . ' - ' . $attributes['end_date'],
        );
    }

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

    protected static function newFactory(): ProjectFactory
    {
        return ProjectFactory::new();
    }

    #endregion
}
