<?php

namespace App\Filament\Resources\CampEvents\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class CampEventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('CampEventTabs')
                    ->tabs([
                        Tab::make('Información General')
                            ->icon(Heroicon::OutlinedInformationCircle)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nombre del campamento')
                                    ->placeholder('Ej. Campamento de Verano')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('year')
                                            ->label('Año')
                                            ->numeric()
                                            ->minValue(2000)
                                            ->maxValue(2100)
                                            ->required(),

                                        Toggle::make('is_active')
                                            ->label('Campamento activo')
                                            ->helperText(
                                                'Determina si este campamento está actualmente disponible.'
                                            )
                                            ->default(true),
                                    ]),
                            ]),

                        Tab::make('Fechas')
                            ->icon(Heroicon::OutlinedCalendarDays)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        DatePicker::make('start_date')
                                            ->label('Fecha de inicio')
                                            ->required()
                                            ->native(false),

                                        DatePicker::make('end_date')
                                            ->label('Fecha de finalización')
                                            ->required()
                                            ->afterOrEqual('start_date')
                                            ->native(false),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}