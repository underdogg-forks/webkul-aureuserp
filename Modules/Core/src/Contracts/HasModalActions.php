<?php

namespace Modules\Core\Contracts;

interface HasModalActions
{
    public function getCachedModalActions(): array;
}
