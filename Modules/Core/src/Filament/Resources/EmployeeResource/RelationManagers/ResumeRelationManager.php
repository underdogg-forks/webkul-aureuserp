<?php

namespace Modules\Core\Filament\Resources\EmployeeResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Modules\Core\Traits\Resources\Employee\EmployeeResumeRelation;

class ResumeRelationManager extends RelationManager
{
    use EmployeeResumeRelation;

    protected static string $relationship = 'resumes';

    protected static ?string $title = 'Resumes';
}
