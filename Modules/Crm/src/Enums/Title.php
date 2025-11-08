<?php

namespace Modules\Crm\Enums;

use Filament\Support\Contracts;

enum Title: string implements Contracts\HasLabel
{
    case MR = 'mr';
    case MRS = 'mrs';
    case MISS = 'miss';
    case DR = 'dr';
    case PROF = 'prof';

    public static function options(): array
    {
        return [
            self::MR->value => __('crm::enums/title.mr'),
            self::MRS->value => __('crm::enums/title.mrs'),
            self::MISS->value => __('crm::enums/title.miss'),
            self::DR->value => __('crm::enums/title.dr'),
            self::PROF->value => __('crm::enums/title.prof'),
        ];
    }

    public static function shortNames(): array
    {
        return [
            self::MR->value => 'Mr.',
            self::MRS->value => 'Mrs.',
            self::MISS->value => 'Miss',
            self::DR->value => 'Dr.',
            self::PROF->value => 'Prof.',
        ];
    }

    public function getLabel(): string
    {
        return self::options()[$this->value];
    }

    public function getShortName(): string
    {
        return self::shortNames()[$this->value];
    }
}
