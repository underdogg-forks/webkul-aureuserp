<?php

namespace Modules\Projects\Filament\Clusters\Configurations\Resources\ProjectStageResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Support\Facades\Auth;
use Modules\Projects\Filament\Clusters\Configurations\Resources\ProjectStageResource;
use Modules\Projects\Models\ProjectStage;

class ManageProjectStages extends ManageRecords
{
    protected static string $resource = ProjectStageResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(__('projects::filament/clusters/configurations/resources/project-stage/pages/manage-project-stages.tabs.all'))
                ->badge(ProjectStage::count()),
            'archived' => Tab::make(__('projects::filament/clusters/configurations/resources/project-stage/pages/manage-project-stages.tabs.archived'))
                ->badge(ProjectStage::onlyTrashed()->count())
                ->modifyQueryUsing(function ($query) {
                    return $query->onlyTrashed();
                }),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('projects::filament/clusters/configurations/resources/project-stage/pages/manage-project-stages.header-actions.create.label'))
                ->icon('heroicon-o-plus-circle')
                ->mutateDataUsing(function (array $data): array {
                    $data['creator_id'] = Auth::id();

                    return $data;
                })
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title(__('projects::filament/clusters/configurations/resources/project-stage/pages/manage-project-stages.header-actions.create.notification.title'))
                        ->body(__('projects::filament/clusters/configurations/resources/project-stage/pages/manage-project-stages.header-actions.create.notification.body')),
                ),
        ];
    }
}
