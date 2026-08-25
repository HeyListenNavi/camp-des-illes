<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Models\Camper;
use App\Models\Document;
use App\Models\GroupEvent;
use App\Models\GuestGroup;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-document-text';

    protected static \UnitEnum|string|null $navigationGroup = 'Gestión Documental';

    protected static ?string $modelLabel = 'Documento';

    protected static ?string $pluralModelLabel = 'Documentos';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Registro de Documento')
                    ->schema([
                        Select::make('documentable_type')
                            ->label('Tipo de Entidad Asociada')
                            ->options([
                                Camper::class => 'Acampante',
                                GuestGroup::class => 'Grupo Visitante',
                                GroupEvent::class => 'Evento de Grupo',
                            ])
                            ->required(),
                        TextInput::make('documentable_id')
                            ->label('ID de Entidad')
                            ->numeric()
                            ->required(),
                        TextInput::make('title')
                            ->label('Título del Documento')
                            ->required()
                            ->maxLength(255),
                        Select::make('file_type')
                            ->label('Tipo de Archivo')
                            ->options([
                                'pdf' => 'PDF',
                                'form' => 'Formulario',
                                'contract' => 'Contrato',
                                'consent' => 'Consentimiento Firmado',
                                'other' => 'Otro',
                            ])
                            ->required(),
                        FileUpload::make('file_path')
                            ->label('Archivo Adjunto')
                            ->directory('documents')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('title')->label('Título')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('file_type')->label('Tipo')->badge(),
                Tables\Columns\TextColumn::make('documentable_type')->label('Entidad')->formatStateUsing(fn ($state) => class_basename($state)),
                Tables\Columns\TextColumn::make('documentable_id')->label('ID Entidad'),
                Tables\Columns\TextColumn::make('uploaded_at')->label('Fecha Subida')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('file_type')
                    ->options([
                        'pdf' => 'PDF',
                        'form' => 'Formulario',
                        'contract' => 'Contrato',
                        'consent' => 'Consentimiento Firmado',
                        'other' => 'Otro',
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
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
