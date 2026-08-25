<?php

namespace App\Filament\Resources\CamperResource\RelationManagers;

use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class GuardiansRelationManager extends RelationManager
{
    protected static string $relationship = 'guardians';

    protected static ?string $title = 'Tutores y Contactos Responsables';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('first_name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),
                TextInput::make('last_name')
                    ->label('Apellido')
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->label('Teléfono')
                    ->required()
                    ->maxLength(50),
                TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('first_name')
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('first_name')->label('Nombre')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('last_name')->label('Apellido')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('phone')->label('Teléfono'),
                Tables\Columns\TextColumn::make('email')->label('Email'),
                Tables\Columns\TextColumn::make('pivot.relationship_type')
                    ->label('Parentesco')
                    ->badge(),
                Tables\Columns\IconColumn::make('pivot.is_primary_guardian')
                    ->label('Tutor Principal')
                    ->boolean(),
                Tables\Columns\IconColumn::make('pivot.is_emergency_contact')
                    ->label('Emergencia')
                    ->boolean(),
            ])
            ->headerActions([
                Actions\CreateAction::make(),
                Actions\AttachAction::make(),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
