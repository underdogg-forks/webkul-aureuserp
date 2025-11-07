<?php

namespace Modules\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Products\Database\Factories\PackageLevelFactory;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;

class PackageLevel extends Model
{
    use HasFactory;

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'inventories_package_levels';

    /**
     * Fillable.
     *
     * @var array
     */
    protected $fillable = [
        'package_id',
        'operation_id',
        'destination_location_id',
        'company_id',
        'creator_id',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function operation(): BelongsTo
    {
        return $this->belongsTo(Operation::class);
    }

    public function destinationLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory(): PackageLevelFactory
    {
        return PackageLevelFactory::new();
    }
}
