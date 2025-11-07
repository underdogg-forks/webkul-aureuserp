<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\User;

class UTMMedium extends Model
{
    protected $table = 'utm_mediums';

    protected $fillable = ['name', 'creator_id'];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
