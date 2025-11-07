<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\VendorResource\Pages;

use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Filament\Clusters\Vendors\Resources\VendorResource\Pages\ListVendors as BaseListVendors;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\VendorResource;

class ListVendors extends BaseListVendors
{
    protected static string $resource = VendorResource::class;

    public function table(Table $table): Table
    {
        $table = parent::table($table)
            ->modifyQueryUsing(fn (Builder $query) => $query->where('sub_type', 'supplier'));

        return $table;
    }
}
