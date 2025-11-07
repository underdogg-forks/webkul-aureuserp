<?php

namespace Modules\Projects\Filament\Resources\TimesheetResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Auth;
use Modules\Projects\Models\Timesheet;
use Modules\Core\Filament\Components\PresetView;
use Modules\Core\Filament\Concerns\HasTableViews;
use Modules\Projects\Filament\Resources\TimesheetResource;

class ManageTimesheets extends ManageRecords
{
    use HasTableViews;

    protected static string $resource = TimesheetResource::class;

    public function getPresetTableViews(): array
    {
        return [
            'my_timesheets' => PresetView::make(__('timesheets::filament/resources/timesheet/manage-timesheets.tabs.my-timesheets'))
                ->badge(fn (): int => Timesheet::where('user_id', Auth::id())->count())
                ->icon('heroicon-o-clock')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('user_id', Auth::id());
                })
                ->favorite(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('timesheets::filament/resources/timesheet/manage-timesheets.header-actions.create.label'))
                ->icon('heroicon-o-plus-circle')
                ->mutateDataUsing(function (array $data): array {
                    $data['creator_id'] = Auth::id();

                    return $data;
                })
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title(__('timesheets::filament/resources/timesheet/manage-timesheets.header-actions.create.notification.title'))
                        ->body(__('timesheets::filament/resources/timesheet/manage-timesheets.header-actions.create.notification.body')),
                ),
        ];
    }
}
