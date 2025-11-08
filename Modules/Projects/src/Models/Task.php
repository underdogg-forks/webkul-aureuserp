<?php

namespace Modules\Projects\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Modules\Core\Traits\HasChatter;
use Modules\Core\Traits\HasLogActivity;
use Modules\Core\Traits\HasCustomFields;
use Modules\Crm\Models\Partner;
use Modules\Projects\Database\Factories\TaskFactory;
use Modules\Projects\Enums\TaskStage as TaskStageEnum;
use Modules\Projects\Enums\TaskState;
use Modules\Core\Models\Scopes\UserPermissionScope;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;
class Task extends BaseModel implements Sortable
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
        'is_active'           => 'boolean',
        'deadline'            => 'datetime',
        'priority'            => 'boolean',
        'is_recurring'        => 'boolean',
        'working_hours_open'  => 'float',
        'working_hours_close' => 'float',
        'allocated_hours'     => 'float',
        'remaining_hours'     => 'float',
        'effective_hours'     => 'float',
        'total_hours_spent'   => 'float',
        'overtime'            => 'float',
        'state'               => TaskState::class,
        'stage'               => TaskStageEnum::class,
    ];
    /**
     * protected $fillable = [
     * 'title',
     * 'description',
     * 'color',
     * 'priority',
     * 'state',
     * 'sort',
     * 'is_active',
     * 'is_recurring',
     * 'deadline',
     * 'working_hours_open',
     * 'working_hours_close',
     * 'allocated_hours',
     * 'remaining_hours',
     * 'effective_hours',
     * 'total_hours_spent',
     * 'subtask_effective_hours',
     * 'overtime',
     * 'progress',
     * 'stage',
     * 'project_id',
     * 'partner_id',
     * 'parent_id',
     * 'company_id',
     * 'creator_id',
     * ];
     */
    protected $guarded = [];

    public string $recordTitleAttribute = 'title';

    public $sortable = [
        'order_column_name'  => 'sort',
        'sort_when_creating' => true,
    ];

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'projects_tasks';

    protected array $logAttributes = [
        'title',
        'description',
        'color',
        'priority',
        'state',
        'sort',
        'is_active',
        'is_recurring',
        'deadline',
        'allocated_hours',
        'stage'        => 'Stage',
        'project.name' => 'Project',
        'partner.name' => 'Partner',
        'parent.title' => 'Parent',
        'company.name' => 'Company',
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
        static::addGlobalScope(new UserPermissionScope('users'));
    }

    /**
     * Bootstrap any application services.
     */
    protected static function boot()
    {
        parent::boot();

        static::updated(function ($task) {
            $task->timesheets()->update([
                'project_id' => $task->project_id,
                'partner_id' => $task->partner_id ?? $task->project?->partner_id,
                'company_id' => $task->company_id ?? $task->project?->company_id,
            ]);
        });
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

    public function milestone(): BelongsTo
    {
        return $this->belongsTo(Milestone::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function subTasks(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'projects_task_tag', 'task_id', 'tag_id');
    }

    public function timesheets(): HasMany
    {
        return $this->hasMany(Timesheet::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'projects_task_users');
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

    protected static function newFactory(): TaskFactory
    {
        return TaskFactory::new();
    }

    #endregion
}
