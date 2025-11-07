<?php

namespace Modules\Core\Filament\Clusters\Configurations\Resources\JobPositionResource\Pages;

use Modules\Core\Filament\Clusters\Configurations\Resources\JobPositionResource\Pages\CreateJobPosition as BaseCreateJobPosition;
use Modules\Core\Filament\Clusters\Configurations\Resources\JobPositionResource;

class CreateJobPosition extends BaseCreateJobPosition
{
    protected static string $resource = JobPositionResource::class;
}
