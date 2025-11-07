<?php

namespace Modules\Core\Filament\Widgets;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Widgets\Widget;
use Modules\Core\Concerns\CanBeConfigured;
use Modules\Core\Concerns\InteractsWithEvents;
use Modules\Core\Concerns\InteractsWithHeaderActions;
use Modules\Core\Concerns\InteractsWithModalActions;
use Modules\Core\Concerns\InteractsWithRawJS;
use Modules\Core\Concerns\InteractsWithRecord;
use Modules\Core\Contracts\HasConfigurations;
use Modules\Core\Contracts\HasEvents;
use Modules\Core\Contracts\HasHeaderActions;
use Modules\Core\Contracts\HasModalActions;
use Modules\Core\Contracts\HasRawJs;
use Modules\Core\Contracts\HasRecords;

class FullCalendarWidget extends Widget implements HasActions, HasConfigurations, HasEvents, HasForms, HasHeaderActions, HasModalActions, HasRawJs, HasRecords
{
    use CanBeConfigured;
    use InteractsWithActions;
    use InteractsWithEvents;
    use InteractsWithForms;
    use InteractsWithHeaderActions;
    use InteractsWithModalActions;
    use InteractsWithRawJS;
    use InteractsWithRecord;

    protected string $view = 'full-calendar::filament.widgets.full-calendar';

    protected int|string|array $columnSpan = 'full';

    public function fetchEvents(array $info): array
    {
        return [];
    }

    public function getFormSchema(): array
    {
        return [];
    }

    protected function headerActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function modalActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function viewAction(): Action
    {
        return ViewAction::make();
    }
}
