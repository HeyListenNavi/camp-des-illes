<?php

namespace App\Filament\Resources\RoomTypes\Tables;

use App\Models\RoomType;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RoomTypesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Room Type')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-home-modern')
                    ->iconColor('primary')
                    ->weight('bold'),

                TextColumn::make('capacity')
                    ->label('Capacity')
                    ->formatStateUsing(fn ($state) => "{$state} persons")
                    ->icon('heroicon-m-user-group')
                    ->sortable(),

                TextColumn::make('price_per_night')
                    ->label('Price / Night')
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