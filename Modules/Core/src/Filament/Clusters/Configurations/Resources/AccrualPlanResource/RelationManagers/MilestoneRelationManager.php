<?php

namespace Modules\Core\Filament\Clusters\Configurations\Resources\AccrualPlanResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Modules\Core\Traits\LeaveAccrualPlan;

class MilestoneRelationManager extends RelationManager
{
    use LeaveAccrualPlan;

    protected static string $relationship = 'leaveAccrualLevels';
}
