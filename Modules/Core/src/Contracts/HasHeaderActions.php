<?php

namespace Modules\Core\Contracts;

interface HasHeaderActions
{
    public function getCachedHeaderActions(): array;
}
