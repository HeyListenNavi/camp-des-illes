<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum MealType: string implements HasLabel, HasColor, HasIcon
{
    case Breakfast = 'breakfast';
    case Lunch = 'lunch';
    case Dinner = 'dinner';
    case Snack = 'snack';
    case Buffet = 'buffet';
    case Other = 'other';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Breakfast => 'Breakfast',
            self::Lunch => 'Lunch',
            self::Dinner => 'Dinner',
            self::Snack => 'Snack',
            self::Buffet => 'Buffet',
            self::Other => 'Other',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Breakfast => 'warning',
            self::Lunch => 'success',
            self::Dinner => 'primary',
            self::Snack => 'info',
            self::Buffet => 'success',
            self::Other => 'gray',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Breakfast => 'heroicon-m-sun',
            self::Lunch => 'heroicon-m-cake',
            self::Dinner => 'heroicon-m-moon',
            self::Snack => 'heroicon-m-sparkles',
            self::Buffet => 'heroicon-m-building-storefront',
            self::Other => 'heroicon-m-cube',
        };
    }
}
