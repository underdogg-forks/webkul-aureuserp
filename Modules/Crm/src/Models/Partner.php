<?php

namespace Modules\Crm\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Modules\Core\Traits\HasChatter;
use Modules\Core\Traits\HasLogActivity;
use Modules\Crm\Database\Factories\PartnerFactory;
use Modules\Crm\Enums\AccountType;
use Modules\Crm\Enums\Title as TitleEnum;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;
use Modules\Core\Models\Country;
use Modules\Core\Models\State;
class Partner extends BaseModel implements FilamentUser
{
    use HasChatter;

    use HasFactory;

    use HasLogActivity;

    use Notifiable;

    use SoftDeletes;

    public $timestamps = false;

    /**
     * Table name.
     *
     * @var string
     */
    protected $casts = [
        'account_type' => AccountType::class,
        'title'        => TitleEnum::class,
        'is_active'    => 'boolean',
    ];
    /**
     * protected $fillable = [
     * 'account_type',
     * 'sub_type',
     * 'name',
     * 'avatar',
     * 'email',
     * 'job_title',
     * 'website',
     * 'tax_id',
     * 'phone',
     * 'mobile',
     * 'color',
     * 'company_registry',
     * 'reference',
     * 'street1',
     * 'street2',
     * 'city',
     * 'zip',
     * 'state_id',
     * 'country_id',
     * 'parent_id',
     * 'creator_id',
     * 'user_id',
     * 'title',
     * 'company_id',
     * 'industry_id',
     * ];
     */
    protected $guarded = [];

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'partners_partners';

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

    public function addresses(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')
            ->where('account_type', AccountType::ADDRESS);
    }

    public function bankAccounts(): HasMany
    {
        return $this->hasMany(BankAccount::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')
            ->where('account_type', '!=', AccountType::ADDRESS);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable', 'taggables');
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

    /**
     * Determine if the user can access the Filament panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    /**
     * Get image url for the product image.
     *
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        if ( ! $this->avatar) {
            return;
        }

        return Storage::url($this->avatar);
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

    protected static function newFactory(): PartnerFactory
    {
        return PartnerFactory::new();
    }

    #endregion
}
