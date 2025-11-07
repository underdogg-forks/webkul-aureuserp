<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\User;

class ApplicantCategory extends Model
{
    protected $table = 'recruitments_applicant_categories';

    protected $fillable = ['name', 'color', 'creator_id'];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
