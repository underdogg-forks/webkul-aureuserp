<?php

namespace Modules\Invoices\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
class TeamMember extends BaseModel
{
    public $timestamps = false;

    protected $casts = [];
    /**
     * protected $fillable = [
     * 'team_id',
     * 'user_id',
     * ];
     */
    protected $guarded = [];

    protected $table = 'sales_team_members';

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
