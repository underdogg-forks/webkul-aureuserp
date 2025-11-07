<?php

namespace Modules\Core\Enums;

enum CompanyStatus: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';

    public static function options(): array
    {
        return [
            self::ACTIVE->value   => __('security::enums/company-status.active'),
            self::INACTIVE->value => __('security::enums/company-status.inactive'),
        ];
    }
}
