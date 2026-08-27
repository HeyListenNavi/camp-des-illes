<?php

namespace App\Filament\Resources\CamperRegistrations\Schemas;

use App\Enums\RegistrationStatus;
use App\Filament\Forms\Components\QrCodeCard;
use App\Models\Camper;
use App\Models\CamperRegistration;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class CamperRegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(['default' => 1, 'lg' => 2])
                    ->schema([
                        Section::make('Camper & Event Selection')
                            ->description('Assign a camper to an active camp session.')
                            ->icon(Heroicon::OutlinedUserGroup)
                            ->schema([
                                Select::make('camper_id')
                                    ->label('Registered Camper')
                                    ->relationship('camper', 'first_name')
                                    ->getOptionLabelFromRecordUsing(
                                        fn (Camper $record): string => "{$record->first_name} {$record->last_name}"
                                    )
                                    ->searchable(['first_name', 'last_name'])
                                    ->preload()
                                    ->native(false)
                                    ->required()
                                    ->columnSpanFull(),

                                Select::make('camp_event_id')
                                    ->label('Camp Session Event')
                                    ->relationship('campEvent', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->native(false)
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(1),

                        Section::make('Status & Public Links')
                            ->description('Manage registration status, portal links, and scannable QR codes.')
                            ->icon(Heroicon::OutlinedClipboardDocumentCheck)
                            ->schema([
                                Select::make('status')
                                    ->label('Registration Status')
                                    ->options(RegistrationStatus::class)
                                    ->native(false)
                                    ->required()
                                    ->columnSpanFull(),
                                    
                                Grid::make(['default' => 1, 'sm' => 2])
                                    ->schema([
                                        QrCodeCard::make('public_link_qr')
                                            ->label('Registration Portal QR Code')
                                            ->url(fn (?CamperRegistration $record): ?string => $record?->token ? url("/public/camper-register?token={$record->token}") : null)
                                            ->caption('Scan to access registration')
                                            ->qrSize(200)
                                            ->columnSpan(1),

                                        QrCodeCard::make('public_medical_qr')
                                            ->label('Medical Consent QR Code')
                                            ->url(fn (?CamperRegistration $record): ?string => $record?->token ? url("/public/medical/{$record->token}") : null)
                                            ->caption('Scan to update medical consent')
                                            ->qrSize(200)
                                            ->columnSpan(1),
                                    ])
                                    ->columnSpanFull(),

                                Grid::make(['default' => 1, 'sm' => 2])
                                    ->schema([
                                        TextInput::make('public_link')
                                            ->label('Public Access Link')
                                            ->prefixIcon(Heroicon::OutlinedLink)
                                            ->formatStateUsing(fn (?CamperRegistration $record): ?string => $record?->token ? url("/public/camper-register?token={$record->token}") : null)
                                            ->placeholder('Generated after saving')
                                            ->disabled()
                                            ->dehydrated(false)
                                            ->copyable()
                                            ->suffixAction(
                                                Action::make('openPublicLink')
                                                    ->icon('heroicon-m-arrow-top-right-on-square')
                                                    ->tooltip('Open public portal link in new tab')
                                                    ->url(fn (?string $state): ?string => $state, shouldOpenInNewTab: true)
                                                    ->visible(fn (?string $state): bool => ! empty($state))
                                            )
                                            ->columnSpan(1),

                                        TextInput::make('public_medical_link')
                                            ->label('Public Medical & Consent Link')
                                            ->prefixIcon(Heroicon::OutlinedHeart)
                                            ->formatStateUsing(fn (?CamperRegistration $record): ?string => $record?->token ? url("/public/medical/{$record->token}") : null)
                                            ->placeholder('Generated after saving')
                                            ->disabled()
                                            ->dehydrated(false)
                                            ->copyable()
                                            ->suffixAction(
                                                Action::make('openMedicalLink')
                                                    ->icon('heroicon-m-arrow-top-right-on-square')
                                                    ->tooltip('Open public medical consent form in new tab')
                                                    ->url(fn (?string $state): ?string => $state, shouldOpenInNewTab: true)
                                                    ->visible(fn (?string $state): bool => ! empty($state))
                                            )
                                            ->columnSpan(1),
                                    ])
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(1),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
