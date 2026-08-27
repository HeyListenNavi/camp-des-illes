<?php

namespace App\Filament\Widgets;

use App\Models\CampEvent;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class UpcomingEventsWidget extends BaseWidget
{
    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                CampEvent::query()->where('is_active', true)->orderBy('start_date', 'asc')->limit(5)
            )
            ->heading('Active Camp Sessions')
            ->columns([
                TextColumn::make('name')
                    ->label('Event Name')
                    ->weight('semibold'),

                TextColumn::make('year')
                    ->label('Year')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('start_date')
                    ->label('Start Date')
                    ->date('M j, Y'),

                TextColumn::make('end_date')
                    ->label('End Date')
                    ->date('M j, Y'),

                TextColumn::make('registrations_count')
                    ->counts('registrations')
                    ->label('Registered Campers')
                    ->badge()
                    ->color('primary'),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->paginated(false);
    }
}
