<?php

namespace Modules\Invoices\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\User;

class Tag extends Model
{
    use HasFactory;

    protected $table = 'sales_tags';

    protected $fillable = [
        'color',
        'name',
        'creator_id',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
