<?php

namespace Modules\Core\Filament\Resources\EmployeeResource\Pages;

use Carbon\Carbon;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Filament\Resources\EmployeeResource;
use Modules\Core\Filament\Components\PresetView;
use Modules\Core\Filament\Concerns\HasTableViews;

class ListEmployees extends ListRecords
{
    use HasTableViews;

    protected static string $resource = EmployeeResource::class;

    public function getPresetTableViews(): array
    {
        return [
            'my_team' => PresetView::make(__('employees::filament/resources/employee/pages/list-employee.tabs.my-team'))
                ->icon('heroicon-m-users')
                ->favorite()
                ->modifyQueryUsing(function (Builder $query) {
                    $user = Auth::user();

                    if ( ! $user->employee) {
                        return $query->whereNull('id');
                    }

                    return $query->where('parent_id', $user->employee->id);
                }),

            'my_department' => PresetView::make(__('employees::filament/resources/employee/pages/list-employee.tabs.my-department'))
                ->icon('heroicon-m-user-group')
                ->favorite()
                ->modifyQueryUsing(function (Builder $query) {
                    $user = Auth::user();

                    if ( ! $user->employee) {
                        return $query->whereNull('id');
                    }

                    return $query->where('department_id', $user->employee->department_id);
                }),

            'archived' => PresetView::make(__('employees::filament/resources/employee/pages/list-employee.tabs.archived'))
                ->icon('heroicon-s-archive-box')
                ->favorite()
                ->modifyQueryUsing(fn (Builder $query) => $query->onlyTrashed()),
            'newly_hired' => PresetView::make(__('employees::filament/resources/employee/pages/list-employee.tabs.newly-hired'))
                ->icon('heroicon-s-calendar')
                ->favorite()
                ->modifyQueryUsing(function (Builder $query) {
                    return $query->where('created_at', '>=', Carbon::now()->subMonth());
                }),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon('heroicon-o-plus-circle')
                ->label(__('employees::filament/resources/employee/pages/list-employee.header-actions.create.label')),
        ];
    }
}
