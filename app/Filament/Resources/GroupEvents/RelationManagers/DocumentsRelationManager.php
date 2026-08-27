<?php

namespace App\Filament\Resources\GroupEvents\RelationManagers;

use App\Enums\DocumentFileType;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';

    protected static ?string $title = 'Documentos del Evento';

    protected static ?string $modelLabel = 'documento';

    protected static ?string $pluralModelLabel = 'documentos';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    TextInput::make('title')
                        ->label('Título del Documento')
                        ->required()
                        ->placeholder('Ej. Contrato Firmado, Póliza de Seguro')
                        ->maxLength(255),

                    Select::make('file_type')
                        ->label('Tipo de Documento')
                        ->options(DocumentFileType::class)
                        ->required(),

                    FileUpload::make('file_path')
                        ->label('Archivo')
                        ->directory('group-documents')
                        ->preserveFilenames()
                        ->openable()
                        ->downloadable()
                        ->columnSpanFull()
                        ->required(),

                    DateTimePicker::make('uploaded_at')
                        ->label('Fecha de Carga')
                        ->default(now())
                        ->required(),
                ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->label('Documento')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('file_type')
                    ->label('Tipo')
                    ->badge(),

                TextColumn::make('uploaded_at')
                    ->label('Fecha de Subida')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Adjuntar Documento'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
