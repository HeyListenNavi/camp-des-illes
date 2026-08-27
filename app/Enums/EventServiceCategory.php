<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum EventServiceCategory: string implements HasLabel, HasColor, HasIcon
{
    case Meal = 'meal';
    case Lodging = 'lodging';
    case Activity = 'activity';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Meal => 'Meal',
            self::Lodging => 'Lodging',
            self::Activity => 'Activity',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Meal => 'primary',
            self::Lodging => 'info',
            self::Activity => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Meal => 'heroicon-m-cake',
            self::Lodging => 'heroicon-m-home',
            self::Activity => 'heroicon-m-sparkles',
        };
    }
}
