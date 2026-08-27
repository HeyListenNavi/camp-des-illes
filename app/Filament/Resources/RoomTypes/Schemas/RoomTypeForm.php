<?php

namespace App\Filament\Resources\RoomTypes\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class RoomTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(['default' => 1, 'lg' => 3])
                    ->schema([
                        Grid::make(1)
                            ->schema([
                                Section::make('Room Details')
                                    ->description('Capacity, naming, and nightly cost.')
                                    ->icon(Heroicon::OutlinedHomeModern)
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Room Type Name')
                                            ->prefixIcon(Heroicon::OutlinedHomeModern)
                                            ->required()
                                            ->maxLength(255),

                                        Textarea::make('description')
                                            ->label('Description')
                                            ->placeholder('e.g. Standard cabin with 4 bunk beds.')
                                            ->rows(3)
                                            ->autosize()
                                            ->columnSpanFull(),

                                        Grid::make(2)->schema([
                                            TextInput::make('capacity')
                                                ->label('Capacity (Persons)')
                                                ->prefixIcon(Heroicon::OutlinedUserGroup)
                                                ->numeric()
                                                ->required()
                                                ->minValue(1),

                                            TextInput::make('price_per_night')
                                                ->label('Price Per Night ($)')
                                                ->prefixIcon(Heroicon::OutlinedCurrencyDollar)
                                                ->numeric()
                                                ->prefix('$')
                                                ->required()
                                                ->step(0.01),
                                        ]),
                                    ]),
                            ])
                            ->columnSpan(['default' => 1, 'lg' => 2]),

                        Grid::make(1)
                            ->schema([
                                Section::make('Status')
                                    ->description('Room availability settings.')
                                    ->icon(Heroicon::OutlinedCheckCircle)
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->label('Active Room Type')
                                            ->helperText('Available for lodging assignments.')
                                            ->default(true),
                                    ]),
                            ])
                            ->columnSpan(['default' => 1, 'lg' => 1]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}