<?php

namespace Modules\Core\Filament\Resources\InvoiceResource\Actions;

use Filament\Actions\Action;
use InvalidArgumentException;
use Modules\Core\Enums\MoveState;
use Modules\Core\Models\Move;
use Modules\Core\Traits\PDFHandler;

class PreviewAction extends Action
{
    use PDFHandler;

    protected string $template = '';

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(__('accounts::filament/resources/invoice/actions/preview.title'))
            ->color('gray')
            ->visible(fn (Move $record) => $record->state == MoveState::POSTED)
            ->icon('heroicon-o-viewfinder-circle')
            ->modalHeading(__('accounts::filament/resources/invoice/actions/preview.modal.title'))
            ->modalSubmitAction(false)
            ->modalContent(fn (Move $record) => view($this->getTemplate(), ['record' => $record]));
    }

    public static function getDefaultName(): ?string
    {
        return 'customers.invoice.preview';
    }

    public function getTemplate(): string
    {
        return (string) $this->template;
    }

    public function setTemplate(string $template): static
    {
        if ( ! view()->exists($template)) {
            throw new InvalidArgumentException("The view [{$template}] does not exist.");
        }

        $this->template = $template;

        return $this;
    }
}
