<?php

namespace Modules\Crm\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Crm\Database\Factories\IndustryFactory;
use Modules\Core\Models\User;

class Industry extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'partners_industries';

    /**
     * Fillable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'is_active',
        'can_send_money',
        'creator_id',
    ];

    /**
     * Table name.
     *
     * @var string
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory(): IndustryFactory
    {
        return IndustryFactory::new();
    }
}
