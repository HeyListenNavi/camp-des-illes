<?php

namespace App\Filament\Resources\MealOptions\Tables;

use App\Models\MealOption;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MealOptionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Meal Name')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-cake')
                    ->iconColor('primary')
                    ->weight('bold'),

                TextColumn::make('meal_type')
                    ->label('Type')
                    ->badge()
                    ->sortable(),

                TextColumn::make('price_per_person')
                    ->label('Price / Person')
                    ->money('USD')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('service_requests_count')
                    ->label('Requests')
                    ->counts('serviceRequests')
                    ->badge()
                    ->color('info')
                    ->sortable(),
            ])
            ->defaultSort('name')
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}