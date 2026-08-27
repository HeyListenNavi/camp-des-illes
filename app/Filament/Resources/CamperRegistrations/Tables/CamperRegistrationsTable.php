<?php

namespace App\Filament\Resources\CamperRegistrations\Tables;

use App\Enums\RegistrationStatus;
use App\Models\CamperRegistration;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CamperRegistrationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('camper.full_name')
                    ->label('Camper Name')
                    ->state(fn (CamperRegistration $record): string => $record->camper ? "{$record->camper->first_name} {$record->camper->last_name}" : 'N/A')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable()
                    ->icon('heroicon-m-user')
                    ->iconColor('primary')
                    ->weight('bold'),

                TextColumn::make('campEvent.name')
                    ->label('Camp Event')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-sparkles'),

                TextColumn::make('campEvent.year')
                    ->label('Year')
                    ->badge()
                    ->color('gray')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('token')
                    ->label('Tracking Token')
                    ->searchable()
                    ->copyable()
                    ->fontFamily('mono')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Registration Date')
                    ->dateTime('M j, Y g:i A')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter by Status')
                    ->options(RegistrationStatus::class)
                    ->native(false),

                SelectFilter::make('camp_event_id')
                    ->label('Filter by Event')
                    ->relationship('campEvent', 'name')
                    ->native(false),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make()->modalWidth('4xl'),
                    EditAction::make()->modalWidth('4xl'),
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
