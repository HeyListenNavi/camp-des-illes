<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum GuardianRelationship: string implements HasLabel, HasColor, HasIcon
{
    case Father = 'father';
    case Mother = 'mother';
    case Stepfather = 'stepfather';
    case Stepmother = 'stepmother';
    case LegalGuardian = 'legal_guardian';
    case Grandparent = 'grandparent';
    case UncleAunt = 'uncle_aunt';
    case EmergencyContact = 'emergency_contact';
    case Other = 'other';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Father => 'Father',
            self::Mother => 'Mother',
            self::Stepfather => 'Stepfather',
            self::Stepmother => 'Stepmother',
            self::LegalGuardian => 'Legal Guardian',
            self::Grandparent => 'Grandparent',
            self::UncleAunt => 'Uncle / Aunt',
            self::EmergencyContact => 'Emergency Contact',
            self::Other => 'Other',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Father, self::Mother => 'primary',
            self::Stepfather, self::Stepmother => 'info',
            self::LegalGuardian => 'warning',
            self::Grandparent, self::UncleAunt => 'success',
            self::EmergencyContact => 'danger',
            self::Other => 'gray',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Father, self::Mother, self::Stepfather, self::Stepmother => 'heroicon-m-user',
            self::LegalGuardian => 'heroicon-m-shield-check',
            self::Grandparent, self::UncleAunt => 'heroicon-m-user-group',
            self::EmergencyContact => 'heroicon-m-phone',
            self::Other => 'heroicon-m-ellipsis-horizontal',
        };
    }
}
