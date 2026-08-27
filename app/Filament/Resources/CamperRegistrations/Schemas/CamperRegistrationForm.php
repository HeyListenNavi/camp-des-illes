<?php

namespace App\Filament\Resources\CamperRegistrations\Schemas;

use App\Models\Camper;
use App\Models\CampEvent;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class CamperRegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        Select::make('camper_id')
                            ->label('Acampante')
                            ->relationship('camper', 'first_name')
                            ->getOptionLabelFromRecordUsing(
                                fn (Camper $record): string => "{$record->first_name} {$record->last_name}"
                            )
                            ->searchable(['first_name', 'last_name'])
                            ->preload()
                            ->required(),

                        Select::make('camp_event_id')
                            ->label('Campamento')
                            ->relationship('campEvent', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('status')
                            ->label('Estado')
                            ->options([
                                'pending' => 'Pendiente',
                                'confirmed' => 'Confirmada',
                                'cancelled' => 'Cancelada',
                            ])
                            ->required(),
                    ]),
            ]);
    }
}