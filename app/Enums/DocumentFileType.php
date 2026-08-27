<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum DocumentFileType: string implements HasLabel, HasColor, HasIcon
{
    case Pdf = 'pdf';
    case Form = 'form';
    case Contract = 'contract';
    case Consent = 'consent';
    case MedicalRelease = 'medical_release';
    case Identification = 'identification';
    case Photo = 'photo';
    case CustodyPaper = 'custody_paper';
    case Other = 'other';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Pdf => 'PDF Document',
            self::Form => 'Form',
            self::Contract => 'Signed Contract',
            self::Consent => 'Consent / Permission',
            self::MedicalRelease => 'Medical Release',
            self::Identification => 'Official ID',
            self::Photo => 'Photo',
            self::CustodyPaper => 'Custody Document',
            self::Other => 'Other Document',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Pdf => 'danger',
            self::Form => 'info',
            self::Contract => 'success',
            self::Consent => 'warning',
            self::MedicalRelease => 'danger',
            self::Identification => 'primary',
            self::Photo => 'info',
            self::CustodyPaper => 'warning',
            self::Other => 'gray',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Pdf => 'heroicon-m-document-text',
            self::Form => 'heroicon-m-clipboard-document-list',
            self::Contract => 'heroicon-m-document-check',
            self::Consent => 'heroicon-m-shield-check',
            self::MedicalRelease => 'heroicon-m-heart',
            self::Identification => 'heroicon-m-identification',
            self::Photo => 'heroicon-m-camera',
            self::CustodyPaper => 'heroicon-m-user-group',
            self::Other => 'heroicon-m-folder',
        };
    }
}
