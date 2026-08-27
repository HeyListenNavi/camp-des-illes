<?php

namespace App\Filament\Resources\Activities\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ActivityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(['default' => 1, 'lg' => 3])
                    ->schema([
                        Grid::make(1)
                            ->schema([
                                Section::make('Activity Details')
                                    ->description('Name, description, and time requirements.')
                                    ->icon(Heroicon::OutlinedSparkles)
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Activity Name')
                                            ->prefixIcon(Heroicon::OutlinedSparkles)
                                            ->required()
                                            ->maxLength(255),

                                        Textarea::make('description')
                                            ->label('Description')
                                            ->placeholder('e.g. Morning outdoor team building activities.')
                                            ->rows(3)
                                            ->autosize()
                                            ->columnSpanFull(),

                                        Grid::make(2)->schema([
                                            TextInput::make('duration_minutes')
                                                ->label('Duration (Minutes)')
                                                ->prefixIcon(Heroicon::OutlinedClock)
                                                ->numeric()
                                                ->required()
                                                ->minValue(1),

                                            TextInput::make('price_per_person')
                                                ->label('Price Per Person ($)')
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
                                    ->description('Availability status.')
                                    ->icon(Heroicon::OutlinedCheckCircle)
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->label('Active Activity')
                                            ->helperText('If enabled, this activity can be requested for events.')
                                            ->default(true),
                                    ]),
                            ])
                            ->columnSpan(['default' => 1, 'lg' => 1]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}