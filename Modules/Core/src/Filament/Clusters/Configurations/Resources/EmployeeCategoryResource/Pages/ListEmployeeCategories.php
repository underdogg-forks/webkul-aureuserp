<?php

namespace Modules\Core\Filament\Clusters\Configurations\Resources\EmployeeCategoryResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Modules\Core\Filament\Clusters\Configurations\Resources\EmployeeCategoryResource;

class ListEmployeeCategories extends ListRecords
{
    protected static string $resource = EmployeeCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon('heroicon-o-plus-circle')
                ->label(__('employees::filament/clusters/configurations/resources/employee-category/pages/list-employee-category.header-actions.create.label'))
                ->mutateDataUsing(function (array $data): array {
                    $data['color'] ??= fake()->hexColor();

                    return $data;
                })
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title(__('employees::filament/clusters/configurations/resources/employee-category/pages/list-employee-category.header-actions.create.notification.title'))
                        ->body(__('employees::filament/clusters/configurations/resources/employee-category/pages/list-employee-category.header-actions.create.notification.body'))
                ),
        ];
    }
}
