<?php

namespace Modules\Core\Filament\Widgets;

use Filament\Widgets\Widget;

class ChatterWidget extends Widget
{
    public $record = null;

    protected string $view = 'chatter::filament.widgets.chatter';

    protected int|string|array $columnSpan = 'full';

    protected static string $type = 'footer';

    public static function canView(): bool
    {
        return true;
    }

    public function mount($record = null)
    {
        $this->record = $record;
    }

    public function getRecord()
    {
        return $this->record;
    }
}
