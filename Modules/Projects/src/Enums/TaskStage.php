<?php

namespace Modules\Projects\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum TaskStage: string implements HasColor, HasIcon, HasLabel
{
    case TO_DO = 'to_do';
    case IN_PROGRESS = 'in_progress';
    case DONE = 'done';
    case CANCELLED = 'cancelled';

    public static function options(): array
    {
        return [
            self::TO_DO->value => __('projects::enums/task-stage.to-do'),
            self::IN_PROGRESS->value => __('projects::enums/task-stage.in-progress'),
            self::DONE->value => __('projects::enums/task-stage.done'),
            self::CANCELLED->value => __('projects::enums/task-stage.cancelled'),
        ];
    }

    public static function icons(): array
    {
        return [
            self::TO_DO->value => 'heroicon-o-clipboard-document-list',
            self::IN_PROGRESS->value => 'heroicon-m-play-circle',
            self::DONE->value => 'heroicon-c-check-circle',
            self::CANCELLED->value => 'heroicon-s-x-circle',
        ];
    }

    public static function colors(): array
    {
        return [
            self::TO_DO->value => 'gray',
            self::IN_PROGRESS->value => 'info',
            self::DONE->value => 'success',
            self::CANCELLED->value => 'danger',
        ];
    }

    public function getLabel(): string
    {
        return self::options()[$this->value] ?? $this->value;
    }

    public function getIcon(): ?string
    {
        return self::icons()[$this->value] ?? null;
    }

    public function getColor(): ?string
    {
        return self::colors()[$this->value] ?? null;
    }
}
