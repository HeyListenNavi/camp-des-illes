<?php

namespace App\Filament\Resources\MealOptions\Schemas;

use App\Enums\MealType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class MealOptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(['default' => 1, 'lg' => 3])
                    ->schema([
                        Grid::make(1)
                            ->schema([
                                Section::make('Meal Information')
                                    ->description('Dietary plan options and pricing.')
                                    ->icon(Heroicon::OutlinedCake)
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Meal Name')
                                            ->prefixIcon(Heroicon::OutlinedCake)
                                            ->required()
                                            ->maxLength(255),

                                        Select::make('meal_type')
                                            ->label('Meal Type')
                                            ->prefixIcon(Heroicon::OutlinedTag)
                                            ->options(MealType::class)
                                            ->required(),

                                        Textarea::make('description')
                                            ->label('Description / Ingredients')
                                            ->placeholder('e.g. Standard vegetarian menu option.')
                                            ->rows(3)
                                            ->autosize()
                                            ->columnSpanFull(),

                                        TextInput::make('price_per_person')
                                            ->label('Price Per Person ($)')
                                            ->prefixIcon(Heroicon::OutlinedCurrencyDollar)
                                            ->numeric()
                                            ->prefix('$')
                                            ->required()
                                            ->step(0.01),
                                    ]),
                            ])
                            ->columnSpan(['default' => 1, 'lg' => 2]),

                        Grid::make(1)
                            ->schema([
                                Section::make('Status')
                                    ->description('Availability configuration.')
                                    ->icon(Heroicon::OutlinedCheckCircle)
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->label('Active Menu Option')
                                            ->helperText('Available for selection in upcoming camp packages.')
                                            ->default(true),
                                    ]),
                            ])
                            ->columnSpan(['default' => 1, 'lg' => 1]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}