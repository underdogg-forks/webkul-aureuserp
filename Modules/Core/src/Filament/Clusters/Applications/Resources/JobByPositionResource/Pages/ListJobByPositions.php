<?php

namespace Modules\Core\Filament\Clusters\Applications\Resources\JobByPositionResource\Pages;

use Modules\Core\Filament\Clusters\Configurations\Resources\JobPositionResource\Pages\ListJobPositions as JobPositionResource;
use Modules\Core\Filament\Clusters\Applications\Resources\JobByPositionResource;

class ListJobByPositions extends JobPositionResource
{
    protected static string $resource = JobByPositionResource::class;

    public function getHeaderActions(): array
    {
        return [];
    }
}
