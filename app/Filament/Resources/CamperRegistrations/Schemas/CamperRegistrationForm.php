<?php

namespace App\Filament\Resources\CamperRegistrations\Schemas;

use App\Enums\RegistrationStatus;
use App\Models\Camper;
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

                        Section::make('Status & Registration Tracking')
                            ->description('Manage registration status and access token.')
                            ->icon(Heroicon::OutlinedClipboardDocumentCheck)
                            ->schema([
                                Select::make('status')
                                    ->label('Registration Status')
                                    ->options(RegistrationStatus::class)
                                    ->native(false)
                                    ->required()
                                    ->columnSpanFull(),

                                TextInput::make('token')
                                    ->label('Tracking Token')
                                    ->prefixIcon(Heroicon::OutlinedKey)
                                    ->placeholder('Auto-generated code')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->copyable()
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(1),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
