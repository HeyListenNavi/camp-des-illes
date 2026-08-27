<?php

namespace App\Filament\Resources\GroupEvents\Tables;

use App\Enums\GroupEventStatus;
use App\Models\GroupEvent;
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
use Illuminate\Support\Carbon;

class GroupEventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('group.name')
                    ->label('Host Group Name')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-building-office-2')
                    ->iconColor('primary')
                    ->weight('bold'),

                TextColumn::make('group.primary_contact_name')
                    ->label('Primary Contact')
                    ->searchable()
                    ->icon('heroicon-m-user'),

                TextColumn::make('group.phone')
                    ->label('Phone Number')
                    ->icon('heroicon-m-phone')
                    ->copyable(),

                TextColumn::make('group.email')
                    ->label('Email Address')
                    ->icon('heroicon-m-envelope')
                    ->searchable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('start_date')
                    ->label('Event Dates')
                    ->state(function (GroupEvent $record): string {
                        if (! $record->start_date || ! $record->end_date) {
                            return 'Dates TBD';
                        }
                        $start = Carbon::parse($record->start_date)->format('M j, Y');
                        $end = Carbon::parse($record->end_date)->format('M j, Y');

                        return "{$start} – {$end}";
                    })
                    ->icon('heroicon-m-calendar')
                    ->sortable(),

                TextColumn::make('duration')
                    ->label('Duration')
                    ->state(function (GroupEvent $record): string {
                        if (! $record->start_date || ! $record->end_date) {
                            return '—';
                        }
                        $days = Carbon::parse($record->start_date)->diffInDays(Carbon::parse($record->end_date)) + 1;

                        return "{$days} ".($days === 1 ? 'day' : 'days');
                    })
                    ->badge()
                    ->color('gray')
                    ->icon('heroicon-m-clock'),

                TextColumn::make('expected_attendees')
                    ->label('Attendees')
                    ->numeric()
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-m-user-group')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Inquiry Status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Submitted Date')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter by Status')
                    ->options(GroupEventStatus::class)
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
                        ->url(fn (GroupEvent $record): ?string => $record->token ? url("/public/group-request?token={$record->token}") : null, shouldOpenInNewTab: true)
                        ->visible(fn (GroupEvent $record): bool => ! empty($record->token)),
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
