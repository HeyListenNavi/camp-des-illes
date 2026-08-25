<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GroupEventResource\Pages;
use App\Models\GroupEvent;
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

class GroupEventResource extends Resource
{
    protected static ?string $model = GroupEvent::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-calendar';

    protected static \UnitEnum|string|null $navigationGroup = 'Gestión de Grupos y Eventos';

    protected static ?string $modelLabel = 'Evento de Grupo';

    protected static ?string $pluralModelLabel = 'Eventos de Grupos';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información del Evento')
                    ->schema([
                        Select::make('guest_group_id')
                            ->label('Grupo Visitante')
                            ->relationship('group', 'name')
                            ->searchable()
                            ->required(),
                        Select::make('status')
                            ->label('Estado Operativo')
                            ->options([
                                'inquiry_received' => 'Solicitud Recibida',
                                'application_sent' => 'Propuesta Enviada',
                                'waiting_for_documents' => 'Esperando Documentos',
                                'deposit_pending' => 'Depósito Pendiente',
                                'confirmed' => 'Confirmado',
                                'completed' => 'Completado',
                                'cancelled' => 'Cancelado',
                            ])
                            ->default('inquiry_received')
                            ->required(),
                        DatePicker::make('start_date')
                            ->label('Fecha de Inicio')
                            ->required(),
                        DatePicker::make('end_date')
                            ->label('Fecha de Término')
                            ->required(),
                        TextInput::make('expected_attendees')
                            ->label('Asistentes Estimados')
                            ->numeric()
                            ->default(20)
                            ->required(),
                        TextInput::make('token')
                            ->label('Token de Seguimiento')
                            ->disabled(),
                        Textarea::make('special_activities')
                            ->label('Actividades Especiales')
                            ->columnSpanFull(),
                        Textarea::make('operational_notes')
                            ->label('Notas Operativas')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('group.name')->label('Grupo')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('start_date')->label('Inicio')->date()->sortable(),
                Tables\Columns\TextColumn::make('end_date')->label('Fin')->date()->sortable(),
                Tables\Columns\TextColumn::make('expected_attendees')->label('Asistentes')->sortable(),
                Tables\Columns\TextColumn::make('status')->label('Estado')->badge(),
                Tables\Columns\TextColumn::make('created_at')->label('Fecha Solicitud')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado Operativo')
                    ->options([
                        'inquiry_received' => 'Solicitud Recibida',
                        'application_sent' => 'Propuesta Enviada',
                        'waiting_for_documents' => 'Esperando Documentos',
                        'deposit_pending' => 'Depósito Pendiente',
                        'confirmed' => 'Confirmado',
                        'completed' => 'Completado',
                        'cancelled' => 'Cancelado',
                    ]),
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
            'index' => Pages\ListGroupEvents::route('/'),
            'create' => Pages\CreateGroupEvent::route('/create'),
            'edit' => Pages\EditGroupEvent::route('/{record}/edit'),
        ];
    }
}
