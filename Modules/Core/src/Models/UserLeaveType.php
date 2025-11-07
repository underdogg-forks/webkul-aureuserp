<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\User;

class UserLeaveType extends Model
{
    public $timestamps = false;

    protected $table = 'time_off_user_leave_types';

    protected $fillable = [
        'user_id',
        'leave_type_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }
}
