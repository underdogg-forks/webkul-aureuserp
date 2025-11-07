<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Modules\Core\Database\Factories\DepartureReasonFactory;
use Modules\Core\Traits\HasCustomFields;
use Modules\Core\Models\User;

class DepartureReason extends Model implements Sortable
{
    use HasCustomFields;
    use HasFactory;
    use SortableTrait;

    public $sortable = [
        'order_column_name'  => 'sort',
        'sort_when_creating' => true,
    ];

    protected $table = 'employees_departure_reasons';

    protected $fillable = [
        'sort',
        'reason_code',
        'creator_id',
        'name',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    /**
     * Get the factory instance for the model.
     */
    protected static function newFactory(): DepartureReasonFactory
    {
        return DepartureReasonFactory::new();
    }
}
