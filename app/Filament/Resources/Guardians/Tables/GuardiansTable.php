<?php

namespace App\Filament\Resources\Guardians\Tables;

use App\Models\Guardian;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GuardiansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label('Guardian Name')
                    ->state(fn (Guardian $record): string => "{$record->first_name} {$record->last_name}")
                    ->searchable(['first_name', 'last_name'])
                    ->sortable()
                    ->icon('heroicon-m-user')
                    ->iconColor('primary')
                    ->weight('bold'),

                TextColumn::make('phone')
                    ->label('Phone Number')
                    ->icon('heroicon-m-phone')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('email')
                    ->label('Email Address')
                    ->icon('heroicon-m-envelope')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),

                TextColumn::make('campers_count')
                    ->label('Linked Campers')
                    ->counts('campers')
                    ->badge()
                    ->color('primary')
                    ->icon('heroicon-m-user-group')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Registered Date')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('last_name')
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
