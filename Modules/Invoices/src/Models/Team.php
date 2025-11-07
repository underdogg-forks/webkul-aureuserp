<?php

namespace Modules\Invoices\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Modules\Core\Traits\HasChatter;
use Modules\Core\Traits\HasLogActivity;
use Modules\Invoices\Database\Factories\TeamFactory;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;

class Team extends Model implements Sortable
{
    use HasChatter;
    use HasFactory;
    use HasLogActivity;
    use SoftDeletes;
    use SortableTrait;

    public $sortable = [
        'order_column_name'  => 'sort',
        'sort_when_creating' => true,
    ];

    protected $table = 'sales_teams';

    protected $fillable = [
        'sort',
        'company_id',
        'user_id',
        'color',
        'creator_id',
        'name',
        'is_active',
        'invoiced_target',
    ];

    protected array $logAttributes = [
        'name',
        'company.name'    => 'Company',
        'user.name'       => 'Team Leader',
        'creator.name'    => 'Creator',
        'is_active'       => 'Status',
        'invoiced_target' => 'Invoiced Target',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'sales_team_members', 'team_id', 'user_id');
    }

    protected static function newFactory(): TeamFactory
    {
        return TeamFactory::new();
    }
}
