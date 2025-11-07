<?php

namespace Modules\Core\Filament\Resources\EmployeeResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Modules\Core\Traits\Resources\Employee\EmployeeSkillRelation;

class SkillsRelationManager extends RelationManager
{
    use EmployeeSkillRelation;

    protected static string $relationship = 'skills';

    protected static ?string $title = 'Skills';
}
