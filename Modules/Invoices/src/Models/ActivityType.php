<?php

namespace Modules\Invoices\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Enums\ActivityChainingType;
use Modules\Core\Enums\ActivityDecorationType;
use Modules\Core\Enums\ActivityDelayFrom;
use Modules\Core\Enums\ActivityDelayUnit;
use Modules\Core\Enums\ActivityTypeAction;
use Modules\Core\Models\ActivityType as BaseActivityType;

class ActivityType extends BaseModel {
    public $timestamps = false;

    protected $casts = [
        'delay_unit'       => ActivityDelayUnit::class,
        'delay_from'       => ActivityDelayFrom::class,
        'decoration_type'  => ActivityDecorationType::class,
        'chaining_type'    => ActivityChainingType::class,
        'category'         => ActivityTypeAction::class,
        'is_active'        => 'boolean',
        'keep_done'        => 'boolean',
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

    #endregion

    #region Relationships
    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

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
