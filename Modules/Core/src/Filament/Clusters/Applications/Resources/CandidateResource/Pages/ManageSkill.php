<?php

namespace Modules\Core\Filament\Clusters\Applications\Resources\CandidateResource\Pages;

use BackedEnum;
use Filament\Resources\Pages\ManageRelatedRecords;
use Modules\Core\Filament\Clusters\Applications\Resources\CandidateResource;
use Modules\Core\Traits\CandidateSkillRelation;
use Modules\Core\Traits\HasRecordNavigationTabs;

class ManageSkill extends ManageRelatedRecords
{
    use CandidateSkillRelation;
    use HasRecordNavigationTabs;

    protected static string $resource = CandidateResource::class;

    protected static string $relationship = 'skills';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-bolt';

    public static function getNavigationLabel(): string
    {
        return __('employees::filament/resources/employee/pages/manage-skill.navigation.title');
    }
}
