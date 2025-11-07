<?php

namespace Modules\Core\Filament\Clusters\Configurations\Resources\JobPositionResource\Pages;

use Modules\Core\Filament\Clusters\Configurations\Resources\JobPositionResource\Pages\ListJobPositions as BaseListJobPositions;
use Modules\Core\Filament\Clusters\Configurations\Resources\JobPositionResource;

class ListJobPositions extends BaseListJobPositions
{
    protected static string $resource = JobPositionResource::class;
}
