<?php

namespace Modules\Core\Contracts;

interface HasConfigurations
{
    public function config(): array;

    public function getConfig(): array;
}
