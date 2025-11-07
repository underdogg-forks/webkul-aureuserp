<?php

namespace Modules\Core\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\DB;
use Modules\Core\Models\User;
use Modules\Core\Models\ActivityType;
use Modules\Core\Models\Company;
class Message extends BaseModel
{
    public $timestamps = false;

    protected $casts = [
        'properties'    => 'array',
        'date_deadline' => 'date',
    ];
    /**
     * protected $fillable = [
     * 'company_id',
     * 'activity_type_id',
     * 'messageable_type',
     * 'messageable_id',
     * 'type',
     * 'name',
     * 'subject',
     * 'body',
     * 'summary',
     * 'is_internal',
     * 'date_deadline',
     * 'pinned_at',
     * 'log_name',
     * 'event',
     * 'assigned_to',
     * 'causer_type',
     * 'causer_id',
     * 'properties',
     * ];
     */
    protected $guarded = [];

    protected $table = 'chatter_messages';

    #region Static Methods
    /*
    |--------------------------------------------------------------------------
    | Static Methods
    |--------------------------------------------------------------------------
    */

    public static function boot()
    {
        parent::boot();

        $user = filament()->auth()->user();

        if ($user) {
            static::creating(function ($data) use ($user) {
                DB::transaction(function () use ($data, $user) {
                    $data->causer_type = $user->getMorphClass();
                    $data->causer_id   = $user->id;
                });
            });

            static::updating(function ($data) use ($user) {
                $data->causer_type = $user->getMorphClass();
                $data->causer_id   = $user->id;
            });
        }
    }

    #endregion

    #region Relationships
    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function activityType()
    {
        return $this->belongsTo(ActivityType::class, 'activity_type_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'message_id');
    }

    public function causer()
    {
        return $this->morphTo();
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function messageable(): MorphTo
    {
        return $this->morphTo();
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

    public function setPropertiesAttribute($value)
    {
        $this->attributes['properties'] = json_encode($value);
    }

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
