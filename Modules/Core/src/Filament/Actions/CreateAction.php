<?php

namespace Modules\Core\Filament\Actions;

use Filament\Actions\CreateAction as BaseCreateAction;
use Modules\Core\Filament\Widgets\FullCalendarWidget;

class CreateAction extends BaseCreateAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->model(fn (FullCalendarWidget $livewire) => $livewire->getModel())
            ->schema(fn (FullCalendarWidget $livewire) => $livewire->getFormSchema())
            ->after(fn (FullCalendarWidget $livewire) => $livewire->refreshRecords())
            ->cancelParentActions();
    }
}
