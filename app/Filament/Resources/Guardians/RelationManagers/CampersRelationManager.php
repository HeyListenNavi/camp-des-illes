<?php

namespace App\Filament\Resources\Guardians\RelationManagers;

use App\Enums\Gender;
use App\Enums\GuardianRelationship;
use App\Models\Camper;
use Filament\Actions\ActionGroup;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CampersRelationManager extends RelationManager
{
    protected static string $relationship = 'campers';

    protected static ?string $title = 'Linked Campers';

    protected static ?string $modelLabel = 'camper';

    protected static ?string $pluralModelLabel = 'campers';

    protected static \BackedEnum|string|null $icon = Heroicon::OutlinedUserGroup;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Camper Profile')
                    ->description('Personal details and identity of the child/camper.')
                    ->icon(Heroicon::OutlinedUser)
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('first_name')
                                ->label('First Name')
                                ->prefixIcon(Heroicon::OutlinedUser)
                                ->required()
                                ->maxLength(255),

                            TextInput::make('last_name')
                                ->label('Last Name')
                                ->prefixIcon(Heroicon::OutlinedUser)
                                ->required()
                                ->maxLength(255),

                            Select::make('gender')
                                ->label('Gender')
                                ->options(Gender::class)
                                ->native(false)
                                ->required(),

                            DatePicker::make('date_of_birth')
                                ->label('Date of Birth')
                                ->prefixIcon(Heroicon::OutlinedCalendar)
                                ->native(false)
                                ->required(),
                        ]),
                    ])
                    ->columnSpanFull(),

                Section::make('Relationship & Role')
                    ->description('Specify guardian relationship and emergency permissions for this camper.')
                    ->icon(Heroicon::OutlinedShieldCheck)
                    ->schema([
                        Grid::make(3)->schema([
                            Select::make('relationship_type')
                                ->label('Relationship Type')
                                ->options(GuardianRelationship::class)
                                ->native(false)
                                ->required(),

                            Toggle::make('is_primary_guardian')
                                ->label('Primary Guardian')
                                ->inline(false),

                            Toggle::make('is_emergency_contact')
                                ->label('Emergency Contact')
                                ->inline(false)
                                ->default(true),
                        ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitle(fn (Camper $record) => "{$record->first_name} {$record->last_name}")
            ->heading('Linked Campers')
            ->columns([
                TextColumn::make('full_name')
                    ->label('Camper Full Name')
                    ->state(fn ($record) => "{$record->first_name} {$record->last_name}")
                    ->searchable(['first_name', 'last_name'])
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('pivot.relationship_type')
                    ->label('Relationship')
                    ->badge()
                    ->formatStateUsing(fn ($state) => GuardianRelationship::tryFrom($state)?->getLabel() ?? $state)
                    ->color(fn ($state) => GuardianRelationship::tryFrom($state)?->getColor() ?? 'gray'),

                IconColumn::make('pivot.is_primary_guardian')
                    ->label('Primary')
                    ->boolean(),

                IconColumn::make('pivot.is_emergency_contact')
                    ->label('Emergency')
                    ->boolean(),

                TextColumn::make('date_of_birth')
                    ->label('Date of Birth')
                    ->date('M j, Y')
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Add New Camper')
                    ->modalHeading('Create & Link New Camper')
                    ->modalWidth('4xl'),

                AttachAction::make()
                    ->label('Link Existing Camper')
                    ->modalHeading('Link Existing Camper to Guardian')
                    ->modalWidth('4xl')
                    ->preloadRecordSelect()
                    ->form(fn (AttachAction $action): array => [
                        Section::make('Select Camper Profile')
                            ->schema([
                                $action->getRecordSelect()->native(false),
                            ])
                            ->columnSpanFull(),

                        Section::make('Relationship & Role')
                            ->schema([
                                Grid::make(3)->schema([
                                    Select::make('relationship_type')
                                        ->label('Relationship Type')
                                        ->options(GuardianRelationship::class)
                                        ->native(false)
                                        ->required(),

                                    Toggle::make('is_primary_guardian')
                                        ->label('Primary Guardian')
                                        ->inline(false),

                                    Toggle::make('is_emergency_contact')
                                        ->label('Emergency Contact')
                                        ->inline(false)
                                        ->default(true),
                                ]),
                            ])
                            ->columnSpanFull(),
                    ]),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make()->modalWidth('4xl'),
                    DetachAction::make()->label('Detach Link'),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
