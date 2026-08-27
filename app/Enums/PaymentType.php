<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PaymentType: string implements HasLabel, HasColor, HasIcon
{
    case Deposit = 'deposit';
    case Partial = 'partial';
    case Balance = 'balance';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Deposit => 'Deposit / Advance',
            self::Partial => 'Partial Payment',
            self::Balance => 'Final Balance',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Deposit => 'info',
            self::Partial => 'warning',
            self::Balance => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Deposit => 'heroicon-m-credit-card',
            self::Partial => 'heroicon-m-banknotes',
            self::Balance => 'heroicon-m-currency-dollar',
        };
    }
}
