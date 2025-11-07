<?php

namespace Modules\Invoices\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Core\Models\Category as BaseCategory;

class Category extends BaseCategory
{
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
