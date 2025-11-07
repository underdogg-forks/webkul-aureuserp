<?php

namespace Modules\Core\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;
use Modules\Core\Models\Country;
class FiscalPosition extends BaseModel implements Sortable
{
    use HasFactory;

    use SortableTrait;

    public $timestamps = false;

    protected $casts = [];
    /**
     * protected $fillable = [
     * 'sort',
     * 'company_id',
     * 'country_id',
     * 'country_group_id',
     * 'creator_id',
     * 'zip_from',
     * 'zip_to',
     * 'foreign_vat',
     * 'name',
     * 'notes',
     * 'auto_reply',
     * 'vat_required',
     * ];
     */
    protected $guarded = [];

    public $sortable = [
        'order_column_name'  => 'sort',
        'sort_when_creating' => true,
    ];

    protected $table = 'accounts_fiscal_positions';

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

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function countryGroup()
    {
        return $this->belongsTo(Country::class, 'country_group_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function fiscalPositionTaxes()
    {
        return $this->hasMany(FiscalPositionTax::class, 'fiscal_position_id');
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
