<?php

namespace App\Filament\Resources\Campers\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RegistrationsRelationManager extends RelationManager
{
    protected static string $relationship = 'registrations';

    protected static ?string $title = 'Inscripciones a Campamentos';

    protected static ?string $modelLabel = 'inscripción';

    protected static ?string $pluralModelLabel = 'inscripciones';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    Select::make('camp_event_id')
                        ->label('Campamento / Evento')
                        ->relationship('campEvent', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),

                    Select::make('status')
                        ->label('Estatus de Inscripción')
                        ->options([
                            'pending' => 'Pendiente',
                            'confirmed' => 'Confirmada',
                            'cancelled' => 'Cancelada',
                            'waitlist' => 'Lista de Espera',
                        ])
                        ->default('pending')
                        ->required(),
                ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('status')
            ->columns([
                TextColumn::make('campEvent.name')
                    ->label('Evento')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('status')
                    ->label('Estatus')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'confirmed' => 'success',
                        'pending' => 'warning',
                        'cancelled' => 'danger',
                        'waitlist' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'confirmed' => 'Confirmada',
                        'pending' => 'Pendiente',
                        'cancelled' => 'Cancelada',
                        'waitlist' => 'Lista de Espera',
                        default => $state,
                    }),

                TextColumn::make('created_at')
                    ->label('Fecha de Registro')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Nueva Inscripción'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}