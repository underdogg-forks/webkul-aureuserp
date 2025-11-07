<?php

namespace Modules\Core\Filament\Admin\Resources\PageResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\Core\Filament\Components\PresetView;
use Modules\Core\Filament\Concerns\HasTableViews;
use Modules\Core\Filament\Admin\Resources\PageResource;

class ListPages extends ListRecords
{
    use HasTableViews;

    protected static string $resource = PageResource::class;

    public function getPresetTableViews(): array
    {
        return [
            'archived' => PresetView::make(__('website::filament/admin/resources/page/pages/list-records.tabs.archived'))
                ->icon('heroicon-s-archive-box')
                ->favorite()
                ->modifyQueryUsing(function ($query) {
                    return $query->onlyTrashed();
                }),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('website::filament/admin/resources/page/pages/list-records.header-actions.create.label'))
                ->icon('heroicon-o-plus-circle'),
        ];
    }
}
