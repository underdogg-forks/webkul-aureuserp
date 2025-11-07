<?php

namespace Modules\Products\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Modules\Products\Database\Factories\PackageTypeFactory;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;
class PackageType extends BaseModel implements Sortable
{
    use HasFactory;

    use SortableTrait;

    public $timestamps = false;

    protected $casts = [];
    /**
     * protected $fillable = [
     * 'name',
     * 'sort',
     * 'barcode',
     * 'height',
     * 'width',
     * 'length',
     * 'base_weight',
     * 'max_weight',
     * 'shipper_package_code',
     * 'package_carrier_type',
     * 'company_id',
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
    protected $table = 'inventories_package_types';

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

    public function creator(): BelongsTo
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

    protected static function newFactory(): PackageTypeFactory
    {
        return PackageTypeFactory::new();
    }

    #endregion
}
