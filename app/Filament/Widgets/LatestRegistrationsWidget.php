<?php

namespace App\Filament\Widgets;

use App\Models\CamperRegistration;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestRegistrationsWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                CamperRegistration::query()->latest()->limit(5)
            )
            ->heading('Recent Camper Registrations')
            ->columns([
                TextColumn::make('camper.first_name')
                    ->label('Camper')
                    ->formatStateUsing(fn ($record) => $record->camper ? $record->camper->first_name.' '.$record->camper->last_name : 'N/A')
                    ->searchable(['first_name', 'last_name']),

                TextColumn::make('campEvent.name')
                    ->label('Camp Event')
                    ->badge()
                    ->color('info'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),

                TextColumn::make('created_at')
                    ->label('Registered Date')
                    ->dateTime('M j, Y g:i A')
                    ->sortable(),
            ])
            ->paginated(false);
    }
}
