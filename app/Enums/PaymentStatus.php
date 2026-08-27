<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PaymentStatus: string implements HasLabel, HasColor, HasIcon
{
    case Paid = 'paid';
    case Partial = 'partial';
    case Pending = 'pending';
    case Overdue = 'overdue';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Paid => 'Paid',
            self::Partial => 'Partially Paid',
            self::Pending => 'Pending Payment',
            self::Overdue => 'Overdue',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Paid => 'success',
            self::Partial => 'info',
            self::Pending => 'warning',
            self::Overdue => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Paid => 'heroicon-m-check-circle',
            self::Partial => 'heroicon-m-clock',
            self::Pending => 'heroicon-m-exclamation-circle',
            self::Overdue => 'heroicon-m-x-circle',
        };
    }
}
