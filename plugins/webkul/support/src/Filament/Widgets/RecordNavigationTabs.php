<?php

namespace Webkul\Support\Filament\Widgets;

use Filament\Widgets\Widget;

class RecordNavigationTabs extends Widget
{
    public array $navigationItems = [];

    protected string $view = 'support::filament.widgets.record-navigation-tabs';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    public function mount(array $navigationItems = []): void
    {
        $this->navigationItems = $navigationItems;
    }
}
