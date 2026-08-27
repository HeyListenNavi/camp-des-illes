<?php

namespace App\Filament\Resources\GroupEvents\RelationManagers;

use App\Enums\EventServiceCategory;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ServiceRequestsRelationManager extends RelationManager
{
    protected static string $relationship = 'serviceRequests';

    protected static ?string $title = 'Servicios Solicitados';

    protected static ?string $modelLabel = 'servicio';

    protected static ?string $pluralModelLabel = 'servicios';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    Select::make('service_category')
                        ->label('Categoría de Servicio')
                        ->options(EventServiceCategory::class)
                        ->required(),

                    TextInput::make('service_name')
                        ->label('Nombre del Servicio')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('quantity')
                        ->label('Cantidad')
                        ->numeric()
                        ->default(1)
                        ->required(),

                    Textarea::make('notes')
                        ->label('Notas')
                        ->rows(2)
                        ->columnSpanFull(),
                ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('service_name')
            ->columns([
                TextColumn::make('service_category')
                    ->label('Categoría')
                    ->badge(),

                TextColumn::make('service_name')
                    ->label('Servicio')
                    ->searchable(),

                TextColumn::make('quantity')
                    ->label('Cantidad')
                    ->numeric(),

                TextColumn::make('notes')
                    ->label('Notas')
                    ->limit(30),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Agregar Servicio'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
