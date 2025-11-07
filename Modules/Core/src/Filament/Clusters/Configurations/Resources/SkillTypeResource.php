<?php

namespace Modules\Core\Filament\Clusters\Configurations\Resources;

use Modules\Core\Filament\Clusters\Configurations\Resources\SkillTypeResource as BaseSkillTypeResource;
use Modules\Core\Filament\Clusters\Configurations;
use Modules\Core\Filament\Clusters\Configurations\Resources\SkillTypeResource\Pages\EditSkillType;
use Modules\Core\Filament\Clusters\Configurations\Resources\SkillTypeResource\Pages\ListSkillTypes;
use Modules\Core\Filament\Clusters\Configurations\Resources\SkillTypeResource\Pages\ViewSkillType;
use Modules\Core\Models\SkillType;

class SkillTypeResource extends BaseSkillTypeResource
{
    protected static ?string $model = SkillType::class;

    protected static ?string $cluster = Configurations::class;

    public static function getNavigationGroup(): string
    {
        return __('recruitments::filament/clusters/configurations/resources/skill-type.navigation.group');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSkillTypes::route('/'),
            'view'  => ViewSkillType::route('/{record}'),
            'edit'  => EditSkillType::route('/{record}/edit'),
        ];
    }
}
