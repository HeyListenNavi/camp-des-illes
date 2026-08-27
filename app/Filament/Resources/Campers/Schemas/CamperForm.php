<?php

namespace App\Filament\Resources\Campers\Schemas;

use App\Enums\Gender;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class CamperForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('CamperTabs')
                    ->tabs([
                        Tab::make('Información General')
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

                                        Select::make('gender')
                                            ->label('Género')
                                            ->options(Gender::class)
                                            ->required(),

                                        DatePicker::make('date_of_birth')
                                            ->label('Fecha de nacimiento')
                                            ->required()
                                            ->maxDate(now()),
                                    ]),
                            ]),

                        Tab::make('Contacto y Custodia')
                            ->icon(Heroicon::OutlinedHome)
                            ->schema([
                                Textarea::make('address')
                                    ->label('Dirección completa')
                                    ->rows(3)
                                    ->columnSpanFull(),

                                Textarea::make('custody_details')
                                    ->label('Detalles de custodia')
                                    ->helperText(
                                        'Instrucciones especiales sobre entrega y recogida del menor.'
                                    )
                                    ->rows(4)
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('Expediente Médico')
                            ->icon(Heroicon::OutlinedHeart)
                            ->schema([
                                TextInput::make('health_card_number')
                                    ->label('Número de seguro / tarjeta de salud')
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Fieldset::make('Detalles clínicos')
                                    ->relationship('medical')
                                    ->schema([
                                        Textarea::make('allergies')
                                            ->label('Alergias')
                                            ->placeholder('Ej. Penicilina, nueces...')
                                            ->rows(3),

                                        Textarea::make('medications')
                                            ->label('Medicamentos actuales')
                                            ->rows(3),

                                        Textarea::make('dietary_restrictions')
                                            ->label('Restricciones alimenticias')
                                            ->rows(3),

                                        Textarea::make('critical_alerts')
                                            ->label('Alertas críticas')
                                            ->rows(3),
                                    ])
                                    ->columns(2)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}