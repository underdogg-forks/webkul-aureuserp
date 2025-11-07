<?php

namespace Modules\Expenses\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Expenses\Database\Factories\RequisitionLineFactory;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;
use Modules\Core\Models\UOM;

class RequisitionLine extends Model
{
    use HasFactory;

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'purchases_requisition_lines';

    /**
     * Fillable.
     *
     * @var array
     */
    protected $fillable = [
        'qty',
        'price_unit',
        'requisition_id',
        'product_id',
        'uom_id',
        'company_id',
        'creator_id',
    ];

    public function requisition(): BelongsTo
    {
        return $this->belongsTo(Requisition::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function uom(): BelongsTo
    {
        return $this->belongsTo(UOM::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory(): RequisitionLineFactory
    {
        return RequisitionLineFactory::new();
    }
}
