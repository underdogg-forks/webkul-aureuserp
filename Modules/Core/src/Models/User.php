<?php

namespace Modules\Core\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\User as BaseUser;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Modules\Core\Models\Department;
use Modules\Core\Models\Employee;
use Modules\Crm\Models\Partner;
use Modules\Core\Models\Company;
class User extends BaseModel implements FilamentUser
{
    use HasRoles;

    use SoftDeletes;

    public $timestamps = false;

    protected $casts = [
        'default_company_id' => 'integer',
    ];
    /**
     * protected $fillable = [
     * //
     * ];
     */
    protected $guarded = [];

    #region Static Methods
    /*
    |--------------------------------------------------------------------------
    | Static Methods
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($user) {
            if ( ! $user->partner_id) {
                $user->handlePartnerCreation($user);
            } else {
                $user->handlePartnerUpdation($user);
            }
        });
    }

    #endregion

    #region Relationships
    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function allowedCompanies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'user_allowed_companies', 'user_id', 'company_id');
    }

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }

    public function defaultCompany(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'default_company_id');
    }

    public function departments()
    {
        return $this->hasMany(Department::class, 'manager_id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id');
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'user_team', 'user_id', 'team_id');
    }

    #endregion

    #region Accessors
    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->mergeFillable([
            'partner_id',
            'language',
            'is_active',
            'default_company_id',
            'resource_permission',
            'is_default',
        ]);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getAvatarUrlAttribute()
    {
        return $this->partner?->avatar_url;
    }

    private function handlePartnerCreation(self $user)
    {
        $partner = $user->partner()->create([
            'creator_id' => Auth::user()->id ?? $user->id,
            'user_id'    => $user->id,
            'sub_type'   => 'partner',
            ...Arr::except($user->toArray(), ['id']),
        ]);

        $user->partner_id = $partner->id;
        $user->save();
    }

    private function handlePartnerUpdation(self $user)
    {
        $partner = Partner::updateOrCreate(
            ['id' => $user->partner_id],
            [
                'creator_id' => Auth::user()->id ?? $user->id,
                'user_id'    => $user->id,
                'sub_type'   => 'partner',
                ...Arr::except($user->toArray(), ['id']),
            ]
        );

        if ($user->partner_id !== $partner->id) {
            $user->partner_id = $partner->id;
            $user->save();
        }
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

    #endregion
}
