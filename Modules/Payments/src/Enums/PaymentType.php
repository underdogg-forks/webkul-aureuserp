<?php

namespace Modules\Payments\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PaymentType: string implements HasColor, HasIcon, HasLabel
{
    case SEND = 'outbound';

    case RECEIVE = 'inbound';

    public static function options(): array
    {
        return [
            self::SEND->value    => __('payments::enums/payment-type.send'),
            self::RECEIVE->value => __('payments::enums/payment-type.receive'),
        ];
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SEND    => __('payments::enums/payment-type.send'),
            self::RECEIVE => __('payments::enums/payment-type.receive'),
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::SEND    => 'heroicon-o-arrow-up-circle',
            self::RECEIVE => 'heroicon-o-arrow-down-circle',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::SEND    => 'danger',
            self::RECEIVE => 'success',
        };
    }
}
