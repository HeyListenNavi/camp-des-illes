<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum GroupEventStatus: string implements HasLabel, HasColor, HasIcon
{
    case InquiryReceived = 'inquiry_received';
    case ApplicationSent = 'application_sent';
    case WaitingForDocuments = 'waiting_for_documents';
    case DepositPending = 'deposit_pending';
    case Confirmed = 'confirmed';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::InquiryReceived => 'Inquiry Received',
            self::ApplicationSent => 'Application Sent',
            self::WaitingForDocuments => 'Waiting for Documents',
            self::DepositPending => 'Deposit Pending',
            self::Confirmed => 'Confirmed',
            self::Completed => 'Completed',
            self::Cancelled => 'Cancelled',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::InquiryReceived => 'info',
            self::ApplicationSent => 'primary',
            self::WaitingForDocuments => 'warning',
            self::DepositPending => 'warning',
            self::Confirmed => 'success',
            self::Completed => 'success',
            self::Cancelled => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::InquiryReceived => 'heroicon-m-inbox',
            self::ApplicationSent => 'heroicon-m-paper-airplane',
            self::WaitingForDocuments => 'heroicon-m-document-text',
            self::DepositPending => 'heroicon-m-banknotes',
            self::Confirmed => 'heroicon-m-check-circle',
            self::Completed => 'heroicon-m-check-badge',
            self::Cancelled => 'heroicon-m-x-circle',
        };
    }
}
