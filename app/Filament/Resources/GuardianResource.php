<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuardianResource\Pages;
use App\Models\Guardian;
use Filament\Actions;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class GuardianResource extends Resource
{
    protected static ?string $model = Guardian::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-users';

    protected static \UnitEnum|string|null $navigationGroup = 'Gestión de Acampantes';

    protected static ?string $modelLabel = 'Tutor / Contacto';

    protected static ?string $pluralModelLabel = 'Tutores y Contactos';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información del Tutor')
                    ->schema([
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
                        Textarea::make('address')
                            ->label('Dirección')
                            ->columnSpanFull(),
                        TextInput::make('access_token')
                            ->label('Token de Acceso')
                            ->disabled(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('first_name')->label('Nombre')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('last_name')->label('Apellido')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('phone')->label('Teléfono')->searchable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->searchable(),
                Tables\Columns\TextColumn::make('campers_count')->label('Acampantes')->counts('campers'),
                Tables\Columns\TextColumn::make('created_at')->label('Fecha Registro')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Actions\EditAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\GuardianResource\RelationManagers\CampersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGuardians::route('/'),
            'create' => Pages\CreateGuardian::route('/create'),
            'edit' => Pages\EditGuardian::route('/{record}/edit'),
        ];
    }
}
