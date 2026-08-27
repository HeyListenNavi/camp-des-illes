<?php

namespace App\Filament\Resources\GroupEvents\RelationManagers;

use App\Enums\DocumentFileType;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';

    protected static ?string $title = 'Event Document Vault';

    protected static ?string $modelLabel = 'event document';

    protected static ?string $pluralModelLabel = 'event documents';

    protected static \BackedEnum|string|null $icon = Heroicon::OutlinedFolder;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Document Information')
                    ->description('Title and file category.')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('title')
                                ->label('Document Title')
                                ->prefixIcon(Heroicon::OutlinedDocumentText)
                                ->placeholder('e.g. Signed Contract, Insurance Policy')
                                ->required()
                                ->maxLength(255),

                            Select::make('file_type')
                                ->label('Document Type')
                                ->options(DocumentFileType::class)
                                ->native(false)
                                ->required(),
                        ]),
                    ])
                    ->columnSpanFull(),

                Section::make('File Upload')
                    ->description('Upload group event contracts, insurance certificates, or layout forms.')
                    ->icon(Heroicon::OutlinedArrowUpTray)
                    ->schema([
                        FileUpload::make('file_path')
                            ->label('File Attachment')
                            ->directory('group-documents')
                            ->preserveFilenames()
                            ->openable()
                            ->downloadable()
                            ->columnSpanFull()
                            ->required(),

                        DateTimePicker::make('uploaded_at')
                            ->label('Upload Date & Time')
                            ->default(now())
                            ->hidden()
                            ->required(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->heading('Event Document Vault')
            ->columns([
                TextColumn::make('title')
                    ->label('Document Title')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-document-text')
                    ->iconColor('primary')
                    ->weight('bold'),

                TextColumn::make('file_type')
                    ->label('Type')
                    ->badge()
                    ->sortable(),

                TextColumn::make('uploaded_at')
                    ->label('Upload Date')
                    ->dateTime('M j, Y g:i A')
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Upload Document')
                    ->modalHeading('Upload Group Event Document')
                    ->modalWidth('4xl'),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make()->modalWidth('4xl'),
                    DeleteAction::make(),
                ]),
            ]);
    }
}
