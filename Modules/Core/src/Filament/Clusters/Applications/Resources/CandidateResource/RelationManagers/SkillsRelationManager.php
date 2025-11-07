<?php

namespace Modules\Core\Filament\Clusters\Applications\Resources\CandidateResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Modules\Core\Traits\CandidateSkillRelation;

class SkillsRelationManager extends RelationManager
{
    use CandidateSkillRelation;

    protected static string $relationship = 'skills';
}
