<?php

namespace Modules\Crm\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Crm\Database\Factories\TagFactory;
use Modules\Core\Models\User;

class Tag extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'partners_tags';

    /**
     * Fillable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'color',
        'creator_id',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory(): TagFactory
    {
        return TagFactory::new();
    }
}
