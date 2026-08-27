<?php

namespace App\Filament\Resources\Guardians\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class GuardianForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('GuardianTabs')
                    ->tabs([
                        Tab::make('Información Personal')
                            ->icon(Heroicon::OutlinedIdentification)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('first_name')
                                            ->label('Nombre(s)')
                                            ->required()
                                            ->maxLength(255),

                                        TextInput::make('last_name')
                                            ->label('Apellidos')
                                            ->required()
                                            ->maxLength(255),

                                        TextInput::make('phone')
                                            ->label('Teléfono')
                                            ->tel()
                                            ->required()
                                            ->maxLength(50),

                                        TextInput::make('email')
                                            ->label('Correo electrónico')
                                            ->email()
                                            ->maxLength(255),
                                    ]),
                            ]),

                        Tab::make('Dirección y Custodia')
                            ->icon(Heroicon::OutlinedHome)
                            ->schema([
                                Textarea::make('address')
                                    ->label('Dirección completa')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}