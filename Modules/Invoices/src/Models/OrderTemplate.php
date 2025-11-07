<?php

namespace Modules\Invoices\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Modules\Core\Models\Journal;
use Modules\Invoices\Enums\OrderDisplayType;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;
class OrderTemplate extends BaseModel implements Sortable
{
    use HasFactory;

    use SortableTrait;

    public $timestamps = false;

    protected $casts = [];
    /**
     * protected $fillable = [
     * 'sort',
     * 'company_id',
     * 'number_of_days',
     * 'creator_id',
     * 'name',
     * 'note',
     * 'journal_id',
     * 'is_active',
     * 'require_signature',
     * 'require_payment',
     * 'prepayment_percentage',
     * ];
     */
    protected $guarded = [];

    public $sortable = [
        'order_column_name'  => 'sort',
        'sort_when_creating' => true,
    ];

    protected $table = 'sales_order_templates';

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

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function journal()
    {
        return $this->belongsTo(Journal::class, 'journal_id');
    }

    #endregion

    #region Accessors
    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function products()
    {
        return $this
            ->hasMany(OrderTemplateProduct::class, 'order_template_id')
            ->whereNull('display_type');
    }

    public function sections()
    {
        return $this
            ->hasMany(OrderTemplateProduct::class, 'order_template_id')
            ->where('display_type', OrderDisplayType::SECTION->value);
    }

    public function notes()
    {
        return $this
            ->hasMany(OrderTemplateProduct::class, 'order_template_id')
            ->where('display_type', OrderDisplayType::NOTE->value);
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
