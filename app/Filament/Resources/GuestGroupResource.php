<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuestGroupResource\Pages;
use App\Models\GuestGroup;
use Filament\Actions;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class GuestGroupResource extends Resource
{
    protected static ?string $model = GuestGroup::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-building-office-2';

    protected static \UnitEnum|string|null $navigationGroup = 'Gestión de Grupos y Eventos';

    protected static ?string $modelLabel = 'Grupo Visitante';

    protected static ?string $pluralModelLabel = 'Grupos Visitantes';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detalles del Grupo')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre del Grupo')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('organization_name')
                            ->label('Organización / Empresa')
                            ->maxLength(255),
                        TextInput::make('primary_contact_name')
                            ->label('Contacto Principal')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('Teléfono')
                            ->required()
                            ->maxLength(50),
                        TextInput::make('email')
                            ->label('Correo Electrónico')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('token')
                            ->label('Token Único de Grupo')
                            ->disabled(),
                        Textarea::make('address')
                            ->label('Dirección')
                            ->columnSpanFull(),
                        Textarea::make('internal_notes')
                            ->label('Notas Internas')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->label('Nombre del Grupo')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('organization_name')->label('Organización')->searchable(),
                Tables\Columns\TextColumn::make('primary_contact_name')->label('Contacto'),
                Tables\Columns\TextColumn::make('phone')->label('Teléfono'),
                Tables\Columns\TextColumn::make('email')->label('Email')->searchable(),
                Tables\Columns\TextColumn::make('events_count')->label('Eventos')->counts('events'),
                Tables\Columns\TextColumn::make('created_at')->label('Fecha Registro')->dateTime()->sortable(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGuestGroups::route('/'),
            'create' => Pages\CreateGuestGroup::route('/create'),
            'edit' => Pages\EditGuestGroup::route('/{record}/edit'),
        ];
    }
}
