<?php

namespace App\Filament\Resources\Campers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;

class CampersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('last_name')
                    ->label('Apellidos')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('date_of_birth')
                    ->label('Edad')
                    ->formatStateUsing(
                        fn ($state) => $state
                            ? Carbon::parse($state)->age . ' años'
                            : '-'
                    )
                    ->sortable(),

                TextColumn::make('gender')
                    ->label('Género')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'M' => 'Masculino',
                        'F' => 'Femenino',
                        'Other' => 'Otro',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'M' => 'info',
                        'F' => 'fuchsia',
                        default => 'gray',
                    }),

                TextColumn::make('medical.allergies')
                    ->label('Alergias')
                    ->limit(30)
                    ->placeholder('Sin registrar')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Registrado')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('last_name')
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}