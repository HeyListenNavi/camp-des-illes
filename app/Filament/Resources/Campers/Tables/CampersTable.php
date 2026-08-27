<?php

namespace App\Filament\Resources\Campers\Tables;

use App\Enums\Gender;
use App\Models\Camper;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;

class CampersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label('Camper Name')
                    ->state(fn (Camper $record): string => "{$record->first_name} {$record->last_name}")
                    ->searchable(['first_name', 'last_name'])
                    ->sortable()
                    ->icon('heroicon-m-user')
                    ->iconColor('primary')
                    ->weight('bold'),

                TextColumn::make('date_of_birth')
                    ->label('Age')
                    ->state(function (Camper $record): string {
                        if (! $record->date_of_birth) {
                            return '—';
                        }
                        $age = Carbon::parse($record->date_of_birth)->age;

                        return "{$age} yrs";
                    })
                    ->badge()
                    ->color('gray')
                    ->sortable(),

                TextColumn::make('gender')
                    ->label('Gender')
                    ->badge()
                    ->sortable(),

                TextColumn::make('medical_status')
                    ->label('Medical Status')
                    ->state(function (Camper $record): string {
                        $med = $record->medical;
                        if (! $med) {
                            return 'Standard';
                        }
                        if (! empty($med->critical_alerts) || ! empty($med->allergies)) {
                            return 'Medical Alert';
                        }

                        return 'Standard';
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Medical Alert' => 'danger',
                        default => 'success',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'Medical Alert' => 'heroicon-m-exclamation-triangle',
                        default => 'heroicon-m-check-circle',
                    }),

                TextColumn::make('health_card_number')
                    ->label('Health Card #')
                    ->searchable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Registered Date')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('last_name')
            ->filters([
                SelectFilter::make('gender')
                    ->label('Filter by Gender')
                    ->options(Gender::class)
                    ->native(false),
            ])
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
