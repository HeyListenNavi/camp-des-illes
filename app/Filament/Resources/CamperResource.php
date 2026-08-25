<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CamperResource\Pages;
use App\Models\Camper;
use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class CamperResource extends Resource
{
    protected static ?string $model = Camper::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-user-group';

    protected static \UnitEnum|string|null $navigationGroup = 'Gestión de Acampantes';

    protected static ?string $modelLabel = 'Acampante';

    protected static ?string $pluralModelLabel = 'Acampantes';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Datos Personales del Acampante')
                    ->schema([
                        TextInput::make('first_name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('last_name')
                            ->label('Apellido')
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
                        TextInput::make('health_card_number')
                            ->label('Nº Seguro / Cartilla Médica')
                            ->maxLength(255),
                        Textarea::make('address')
                            ->label('Dirección')
                            ->columnSpanFull(),
                        Textarea::make('custody_details')
                            ->label('Detalles de Custodia / Notas Legales')
                            ->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('guardians.first_name')
                    ->label('Tutor Principal')
                    ->formatStateUsing(function ($record) {
                        $primary = $record->guardians->first(fn ($g) => $g->pivot->is_primary_guardian) ?? $record->guardians->first();
                        return $primary ? ($primary->first_name . ' ' . $primary->last_name . ' (' . ucfirst($primary->pivot->relationship_type ?? 'Tutor') . ')') : 'Sin Tutor';
                    }),
                Tables\Columns\TextColumn::make('gender')->label('Género')->badge(),
                Tables\Columns\TextColumn::make('date_of_birth')->label('Fecha Nac.')->date()->sortable(),
                Tables\Columns\TextColumn::make('health_card_number')->label('Nº Seguro'),
                Tables\Columns\TextColumn::make('created_at')->label('Registrado')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('gender')
                    ->label('Género')
                    ->options([
                        'male' => 'Masculino',
                        'female' => 'Femenino',
                        'other' => 'Otro',
                    ]),
            ])
            ->actions([
                Actions\ViewAction::make(),
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
            \App\Filament\Resources\CamperResource\RelationManagers\GuardiansRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCampers::route('/'),
            'create' => Pages\CreateCamper::route('/create'),
            'edit' => Pages\EditCamper::route('/{record}/edit'),
        ];
    }
}
