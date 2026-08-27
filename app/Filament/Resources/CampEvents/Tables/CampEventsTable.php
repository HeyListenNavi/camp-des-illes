<?php

namespace App\Filament\Resources\CampEvents\Tables;

use App\Models\CampEvent;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;

class CampEventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Event Name')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-sparkles')
                    ->iconColor('primary')
                    ->weight('bold'),

                TextColumn::make('year')
                    ->label('Year')
                    ->badge()
                    ->color('gray')
                    ->sortable(),

                TextColumn::make('start_date')
                    ->label('Event Dates')
                    ->state(function (CampEvent $record): string {
                        if (! $record->start_date || ! $record->end_date) {
                            return 'Dates TBD';
                        }
                        $start = Carbon::parse($record->start_date)->format('M j, Y');
                        $end = Carbon::parse($record->end_date)->format('M j, Y');

                        return "{$start} - {$end}";
                    })
                    ->icon('heroicon-m-calendar')
                    ->sortable(),

                TextColumn::make('duration')
                    ->label('Duration')
                    ->state(function (CampEvent $record): string {
                        if (! $record->start_date || ! $record->end_date) {
                            return '—';
                        }
                        $days = Carbon::parse($record->start_date)->diffInDays(Carbon::parse($record->end_date)) + 1;

                        return "{$days} ".($days === 1 ? 'day' : 'days');
                    })
                    ->badge()
                    ->color('gray')
                    ->icon('heroicon-m-clock'),

                TextColumn::make('registrations_count')
                    ->label('Registered Campers')
                    ->counts('registrations')
                    ->badge()
                    ->color('primary')
                    ->icon('heroicon-m-user-group')
                    ->sortable(),

                ToggleColumn::make('is_active')
                    ->label('Active'),
            ])
            ->defaultSort('start_date', 'desc')
            ->filters([
                SelectFilter::make('is_active')
                    ->label('Session Status')
                    ->options([
                        '1' => 'Active Sessions Only',
                        '0' => 'Inactive Sessions Only',
                    ])
                    ->native(false),

                SelectFilter::make('year')
                    ->label('Session Year')
                    ->options(function () {
                        $current = (int) date('Y');
                        $years = range($current - 5, $current + 5);

                        return array_combine($years, $years);
                    })
                    ->native(false),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),

                    Action::make('duplicate')
                        ->label('Duplicate')
                        ->icon('heroicon-m-square-2-stack')
                        ->color('gray')
                        ->requiresConfirmation()
                        ->modalHeading('Duplicate Camp Event Template')
                        ->modalDescription('Are you sure you want to duplicate this camp event for a new session?')
                        ->action(function (CampEvent $record) {
                            $duplicate = $record->replicate();
                            $duplicate->name = $record->name.' (Copy)';
                            $duplicate->year = $record->year + 1;
                            $duplicate->save();

                            Notification::make()
                                ->title('Camp Event Duplicated')
                                ->body("Created copy: {$duplicate->name} for year {$duplicate->year}.")
                                ->success()
                                ->send();
                        }),
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
