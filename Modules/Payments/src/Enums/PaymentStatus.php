<?php

namespace Modules\Payments\Enums;

use Filament\Support\Contracts\HasLabel;

enum PaymentStatus: string implements HasLabel
{
    case DRAFT = 'draft';

    case IN_PROCESS = 'in_process';

    case PAID = 'paid';

    case NOT_PAID = 'not_paid';

    case CANCELED = 'canceled';

    case REJECTED = 'rejected';

    public static function options(): array
    {
        return [
            self::DRAFT->value      => __('payments::enums/payment-status.draft'),
            self::IN_PROCESS->value => __('payments::enums/payment-status.in-process'),
            self::PAID->value       => __('payments::enums/payment-status.paid'),
            self::NOT_PAID->value   => __('payments::enums/payment-status.not-paid'),
            self::CANCELED->value   => __('payments::enums/payment-status.canceled'),
            self::REJECTED->value   => __('payments::enums/payment-status.rejected'),
        ];
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::DRAFT      => __('payments::enums/payment-status.draft'),
            self::IN_PROCESS => __('payments::enums/payment-status.in-process'),
            self::PAID       => __('payments::enums/payment-status.paid'),
            self::NOT_PAID   => __('payments::enums/payment-status.not-paid'),
            self::CANCELED   => __('payments::enums/payment-status.canceled'),
            self::REJECTED   => __('payments::enums/payment-status.rejected'),
        };
    }
}
