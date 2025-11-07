<?php

namespace Modules\Expenses\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Core\Models\Move;
use Modules\Core\Models\Partner as BasePartner;

class Partner extends BasePartner
{
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function accountMoves(): HasMany
    {
        return $this->hasMany(Move::class);
    }
}
