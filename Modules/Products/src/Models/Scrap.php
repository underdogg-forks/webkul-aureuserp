<?php

namespace Modules\Products\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Modules\Core\Traits\HasChatter;
use Modules\Core\Traits\HasLogActivity;
use Modules\Products\Database\Factories\ScrapFactory;
use Modules\Products\Enums\ScrapState;
use Modules\Crm\Models\Partner;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;
use Modules\Core\Models\UOM;
class Scrap extends BaseModel
{
    use HasChatter;

    use HasFactory;

    use HasLogActivity;

    public $timestamps = false;

    /**
     * Table name.
     *
     * @var string
     */
    protected $casts = [
        'state'            => ScrapState::class,
        'should_replenish' => 'boolean',
        'closed_at'        => 'datetime',
    ];
    /**
     * protected $fillable = [
     * 'name',
     * 'origin',
     * 'state',
     * 'qty',
     * 'should_replenish',
     * 'closed_at',
     * 'product_id',
     * 'uom_id',
     * 'lot_id',
     * 'package_id',
     * 'partner_id',
     * 'operation_id',
     * 'source_location_id',
     * 'destination_location_id',
     * 'company_id',
     * 'creator_id',
     * ];
     */
    protected $guarded = [];

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'inventories_scraps';

    protected array $logAttributes = [
        'name',
        'origin',
        'state',
        'qty',
        'should_replenish',
        'closed_at',
        'product.name'                  => 'Product',
        'uom.name'                      => 'UOM',
        'lot.name'                      => 'Lot',
        'package.name'                  => 'Package',
        'partner.name'                  => 'Partner',
        'operation.name'                => 'Operation',
        'sourceLocation.full_name'      => 'Source Location',
        'destinationLocation.full_name' => 'Destination Location',
        'company.name'                  => 'Company',
        'creator.name'                  => 'Creator',
    ];

    #region Static Methods
    /*
    |--------------------------------------------------------------------------
    | Static Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Bootstrap any application services.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($scrap) {
            $scrap->updateName();
        });
    }

    #endregion

    #region Relationships
    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function destinationLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function lot(): BelongsTo
    {
        return $this->belongsTo(Lot::class);
    }

    public function moveLines(): HasManyThrough
    {
        return $this->hasManyThrough(MoveLine::class, Move::class);
    }

    public function moves(): HasMany
    {
        return $this->hasMany(Move::class);
    }

    public function operation(): BelongsTo
    {
        return $this->belongsTo(Operation::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function sourceLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable', 'taggables');
    }

    public function uom(): BelongsTo
    {
        return $this->belongsTo(UOM::class);
    }

    #endregion

    #region Accessors
    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Update the full name without triggering additional events.
     */
    public function updateName()
    {
        $this->name = 'SP/' . $this->id;
    }

    #endregion

    #region Mutators
    /*
    |--------------------------------------------------------------------------
    | Mutators
    |--------------------------------------------------------------------------
    */

    #endregion

    #region Scopes
    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    #endregion

    #region Factory
    /*
    |--------------------------------------------------------------------------
    | Factory
    |--------------------------------------------------------------------------
    */

    protected static function newFactory(): ScrapFactory
    {
        return ScrapFactory::new();
    }

    #endregion
}
