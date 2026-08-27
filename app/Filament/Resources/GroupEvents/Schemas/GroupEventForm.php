<?php

namespace App\Filament\Resources\GroupEvents\Schemas;

use App\Enums\GroupEventStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GroupEventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        Section::make('Datos del Grupo Solicitante')
                            ->relationship('group')
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

                                Textarea::make('address')
                                    ->label('Dirección')
                                    ->rows(2)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        Section::make('Detalles del Evento de Grupo')
                            ->schema([
                                Select::make('status')
                                    ->label('Estatus de la Solicitud')
                                    ->options(GroupEventStatus::class)
                                    ->default(GroupEventStatus::InquiryReceived)
                                    ->required()
                                    ->columnSpanFull(),

                                DatePicker::make('start_date')
                                    ->label('Fecha de Inicio')
                                    ->required(),

                                DatePicker::make('end_date')
                                    ->label('Fecha de Término')
                                    ->required(),

                                TextInput::make('expected_attendees')
                                    ->label('Asistentes Esperados')
                                    ->numeric()
                                    ->required()
                                    ->columnSpanFull(),

                                Textarea::make('operational_notes')
                                    ->label('Notas Operativas / Requerimientos Especiales')
                                    ->rows(4)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                    ]),
            ]);
    }
}
