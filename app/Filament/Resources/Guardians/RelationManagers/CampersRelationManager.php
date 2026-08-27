<?php

namespace App\Filament\Resources\Guardians\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CampersRelationManager extends RelationManager
{
    protected static string $relationship = 'campers';

    protected static ?string $title = 'Acampantes a Cargo';

    protected static ?string $modelLabel = 'acampante';

    protected static ?string $pluralModelLabel = 'acampantes';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    TextInput::make('first_name')
                        ->label('Nombre(s)')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('last_name')
                        ->label('Apellido(s)')
                        ->required()
                        ->maxLength(255),

                    Select::make('gender')
                        ->label('Género')
                        ->options([
                            'male' => 'Masculino',
                            'female' => 'Femenino',
                            'other' => 'Otro',
                        ])
                        ->required(),

                    DatePicker::make('date_of_birth')
                        ->label('Fecha de Nacimiento')
                        ->required(),
                ]),

                Grid::make(3)->schema([
                    Select::make('relationship_type')
                        ->label('Parentesco')
                        ->options([
                            'Padre' => 'Padre',
                            'Madre' => 'Madre',
                            'Tutor Legal' => 'Tutor Legal',
                            'Abuelo/a' => 'Abuelo/a',
                            'Tío/a' => 'Tío/a',
                            'Otro' => 'Otro',
                        ])
                        ->required(),

                    Checkbox::make('is_primary_guardian')
                        ->label('Tutor Principal'),

                    Checkbox::make('is_emergency_contact')
                        ->label('Contacto de Emergencia')
                        ->default(true),
                ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('first_name')
            ->columns([
                TextColumn::make('first_name')
                    ->label('Nombre Completo')
                    ->formatStateUsing(fn ($record) => "{$record->first_name} {$record->last_name}")
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(),

                TextColumn::make('pivot.relationship_type')
                    ->label('Parentesco')
                    ->badge(),

                IconColumn::make('pivot.is_primary_guardian')
                    ->label('Principal')
                    ->boolean(),

                IconColumn::make('pivot.is_emergency_contact')
                    ->label('Emergencia')
                    ->boolean(),

                TextColumn::make('date_of_birth')
                    ->label('Fecha Nacimiento')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Crear y Asociar Acampante'),
                AttachAction::make()
                    ->label('Vincular Acampante Existente')
                    ->preloadRecordSelect()
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Select::make('relationship_type')
                            ->label('Parentesco')
                            ->options([
                                'Padre' => 'Padre',
                                'Madre' => 'Madre',
                                'Tutor Legal' => 'Tutor Legal',
                                'Abuelo/a' => 'Abuelo/a',
                                'Tío/a' => 'Tío/a',
                                'Otro' => 'Otro',
                            ])
                            ->required(),
                        Checkbox::make('is_primary_guardian')
                            ->label('Es Tutor Principal'),
                        Checkbox::make('is_emergency_contact')
                            ->label('Es Contacto de Emergencia')
                            ->default(true),
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DetachAction::make()->label('Desvincular'),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}