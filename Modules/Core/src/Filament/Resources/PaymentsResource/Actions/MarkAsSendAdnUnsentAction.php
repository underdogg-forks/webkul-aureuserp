<?php

namespace Modules\Core\Filament\Resources\PaymentsResource\Actions;

use Filament\Actions\Action;
use Livewire\Component;
use Modules\Payments\Enums\PaymentStatus;
use Modules\Core\Models\Payment;

class MarkAsSendAdnUnsentAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn (Payment $record) => $record->is_sent ? __('accounts::filament/resources/payment/actions/set-as-send-and-unsend-action.unmark-as-sent') : __('accounts::filament/resources/payment/actions/set-as-send-and-unsend-action.mark-as-sent'))
            ->color('gray')
            ->action(function (Payment $record, Component $livewire): void {
                $record->is_sent = ! $record->is_sent;
                $record->save();

                $livewire->refreshFormData(['state']);
            })
            ->hidden(function (Payment $record) {
                return $record->state !== PaymentStatus::IN_PROCESS->value
                    || ($record->paymentMethodLine?->paymentMethod?->code ?? '') !== 'manual';
            });
    }

    public static function getDefaultName(): ?string
    {
        return 'customers.payment.mark-as-sent-or-unsent';
    }
}
