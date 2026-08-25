<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormSubmissionResource\Pages;
use App\Models\FormSubmission;
use Filament\Actions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class FormSubmissionResource extends Resource
{
    protected static ?string $model = FormSubmission::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static \UnitEnum|string|null $navigationGroup = 'Auditoría e Ingesta';

    protected static ?string $modelLabel = 'Auditoría de Ingesta';

    protected static ?string $pluralModelLabel = 'Auditoría de Ingesta';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detalles del Registro de Ingesta')
                    ->schema([
                        TextInput::make('token')
                            ->label('Token Único de Ingesta')
                            ->disabled(),
                        TextInput::make('form_type')
                            ->label('Tipo de Formulario')
                            ->disabled(),
                        TextInput::make('ip_address')
                            ->label('Dirección IP')
                            ->disabled(),
                        DateTimePicker::make('processed_at')
                            ->label('Fecha / Hora Procesado')
                            ->disabled(),
                        KeyValue::make('payload')
                            ->label('Payload Snapshot de Ingesta')
                            ->columnSpanFull()
                            ->disabled(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('token')->label('Token')->searchable()->copyable(),
                Tables\Columns\TextColumn::make('form_type')->label('Tipo Formulario')->badge(),
                Tables\Columns\TextColumn::make('ip_address')->label('Dirección IP')->searchable(),
                Tables\Columns\TextColumn::make('processed_at')->label('Procesado el')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Fecha')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('form_type')
                    ->options([
                        'registration' => 'Inscripción',
                        'medical' => 'Médico',
                        'consent' => 'Consentimiento',
                    ]),
            ])
            ->actions([
                Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFormSubmissions::route('/'),
        ];
    }
}
