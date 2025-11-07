<?php

namespace Modules\Core\Filament\Resources\PaymentsResource\Actions;

use Filament\Actions\Action;
use Livewire\Component;
use Modules\Payments\Enums\PaymentStatus;
use Modules\Core\Models\Payment;

class ConfirmAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(__('accounts::filament/resources/payment/actions/confirm-action.title'))
            ->color('gray')
            ->action(function (Payment $record, Component $livewire): void {
                $record->state = PaymentStatus::IN_PROCESS->value;
                $record->save();

                $livewire->refreshFormData(['state']);
            })
            ->hidden(function (Payment $record) {
                return $record->state != PaymentStatus::DRAFT->value;
            });
    }

    public static function getDefaultName(): ?string
    {
        return 'customers.payment.confirm';
    }
}
