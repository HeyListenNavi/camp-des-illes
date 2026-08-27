<?php

namespace App\Filament\Resources\CamperRegistrations\Tables;

use App\Enums\RegistrationStatus;
use App\Models\CamperRegistration;
use Filament\Actions\Action;
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
                    Action::make('openPortal')
                        ->label('Open Portal Link')
                        ->icon('heroicon-m-arrow-top-right-on-square')
                        ->color('info')
                        ->url(fn (CamperRegistration $record): ?string => $record->token ? url("/public/camper-register?token={$record->token}") : null, shouldOpenInNewTab: true)
                        ->visible(fn (CamperRegistration $record): bool => ! empty($record->token)),
                    Action::make('openMedicalPortal')
                        ->label('Open Medical & Consent Form')
                        ->icon('heroicon-m-heart')
                        ->color('warning')
                        ->url(fn (CamperRegistration $record): ?string => $record->token ? url("/public/medical/{$record->token}") : null, shouldOpenInNewTab: true)
                        ->visible(fn (CamperRegistration $record): bool => ! empty($record->token)),
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
