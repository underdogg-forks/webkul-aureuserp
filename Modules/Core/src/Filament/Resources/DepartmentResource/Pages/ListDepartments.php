<?php

namespace Modules\Core\Filament\Resources\DepartmentResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Filament\Resources\DepartmentResource;
use Modules\Core\Filament\Components\PresetView;
use Modules\Core\Filament\Concerns\HasTableViews;

class ListDepartments extends ListRecords
{
    use HasTableViews;

    protected static string $resource = DepartmentResource::class;

    public function getPresetTableViews(): array
    {
        return [
            'archived' => PresetView::make('Archived')
                ->icon('heroicon-s-archive-box')
                ->favorite()
                ->label(__('employees::filament/resources/department/pages/list-department.tabs.archived-departments'))
                ->modifyQueryUsing(fn (Builder $query) => $query->onlyTrashed()),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('employees::filament/resources/department/pages/list-department.header-actions.create.label'))
                ->icon('heroicon-o-plus-circle'),
        ];
    }
}
