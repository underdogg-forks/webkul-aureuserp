<?php

namespace Modules\Core\Filament\Actions;

use Filament\Actions\EditAction as BaseEditAction;
use Modules\Core\Filament\Widgets\FullCalendarWidget;

class EditAction extends BaseEditAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->schema(fn (FullCalendarWidget $livewire) => $livewire->getFormSchema())
            ->model(fn (FullCalendarWidget $livewire) => $livewire->getModel())
            ->record(fn (FullCalendarWidget $livewire) => $livewire->getRecord())
            ->schema(fn (FullCalendarWidget $livewire) => $livewire->getFormSchema())
            ->after(fn (FullCalendarWidget $livewire) => $livewire->refreshRecords())
            ->successNotification(null);
    }
}
