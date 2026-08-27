<?php

namespace App\Filament\Resources\GroupEvents\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GroupEventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('group.name')
                    ->label('Nombre del Grupo')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('group.primary_contact_name')
                    ->label('Contacto Principal')
                    ->searchable(),

                TextColumn::make('group.email')
                    ->label('Correo Electrónico')
                    ->searchable(),

                TextColumn::make('group.phone')
                    ->label('Teléfono'),

                TextColumn::make('start_date')
                    ->label('Inicio')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label('Término')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('expected_attendees')
                    ->label('Asistentes')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Estatus')
                    ->badge(),

                TextColumn::make('created_at')
                    ->label('Fecha Solicitud')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
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
