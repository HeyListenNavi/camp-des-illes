<?php

namespace App\Filament\Resources\GroupEvents\RelationManagers;

use App\Enums\EventServiceCategory;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ServiceRequestsRelationManager extends RelationManager
{
    protected static string $relationship = 'serviceRequests';

    protected static ?string $title = 'Requested Event Services';

    protected static ?string $modelLabel = 'service request';

    protected static ?string $pluralModelLabel = 'service requests';

    protected static \BackedEnum|string|null $icon = Heroicon::OutlinedWrench;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Service Specification')
                    ->description('Specify service details, category, and requested quantity.')
                    ->icon(Heroicon::OutlinedWrench)
                    ->schema([
                        Grid::make(3)->schema([
                            Select::make('service_category')
                                ->label('Service Category')
                                ->options(EventServiceCategory::class)
                                ->native(false)
                                ->required()
                                ->columnSpan(1),

                            TextInput::make('service_name')
                                ->label('Service Name')
                                ->prefixIcon(Heroicon::OutlinedWrench)
                                ->placeholder('e.g. AV Projection System, Campfire Setup')
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(1),

                            TextInput::make('quantity')
                                ->label('Quantity / Units')
                                ->numeric()
                                ->default(1)
                                ->required()
                                ->columnSpan(1),
                        ]),

                        Textarea::make('notes')
                            ->label('Special Requirements / Notes')
                            ->placeholder('Add specific setup instructions, room numbers, or notes...')
                            ->rows(3)
                            ->autosize()
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('service_name')
            ->heading('Requested Event Services')
            ->columns([
                TextColumn::make('service_name')
                    ->label('Service Name')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-wrench')
                    ->iconColor('primary')
                    ->weight('bold'),

                TextColumn::make('service_category')
                    ->label('Category')
                    ->badge()
                    ->sortable(),

                TextColumn::make('quantity')
                    ->label('Quantity')
                    ->numeric()
                    ->badge()
                    ->color('gray')
                    ->sortable(),

                TextColumn::make('notes')
                    ->label('Notes')
                    ->limit(40),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Add Requested Service')
                    ->modalHeading('Add Event Service Request')
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
