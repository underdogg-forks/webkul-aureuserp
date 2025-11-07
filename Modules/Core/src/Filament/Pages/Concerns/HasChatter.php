<?php

namespace Modules\Core\Filament\Pages\Concerns;

use Modules\Core\Filament\Widgets\ChatterWidget;

trait HasChatter
{
    protected function getFooterWidgets(): array
    {
        return [
            ChatterWidget::class,
        ];
    }
}
