<?php

namespace App\Filament\Resources\Campers\RelationManagers;

use App\Enums\GuardianRelationship;
use App\Models\Guardian;
use Filament\Actions\ActionGroup;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
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

class GuardiansRelationManager extends RelationManager
{
    protected static string $relationship = 'guardians';

    protected static ?string $title = 'Parents & Guardians';

    protected static ?string $modelLabel = 'guardian';

    protected static ?string $pluralModelLabel = 'guardians';

    protected static \BackedEnum|string|null $icon = Heroicon::OutlinedUsers;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Guardian Information')
                    ->description('Contact and identity details of the parent or guardian.')
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

                            TextInput::make('phone')
                                ->label('Phone Number')
                                ->prefixIcon(Heroicon::OutlinedPhone)
                                ->tel()
                                ->required()
                                ->maxLength(50),

                            TextInput::make('email')
                                ->label('Email Address')
                                ->prefixIcon(Heroicon::OutlinedEnvelope)
                                ->email()
                                ->maxLength(255),
                        ]),
                    ])
                    ->columnSpanFull(),

                Section::make('Relationship & Access Permissions')
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
            ->recordTitle(fn (Guardian $record) => "{$record->first_name} {$record->last_name}")
            ->heading('Parents & Guardians')
            ->columns([
                TextColumn::make('full_name')
                    ->label('Guardian Full Name')
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

                TextColumn::make('phone')
                    ->label('Phone Number')
                    ->icon('heroicon-m-phone')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('email')
                    ->label('Email Address')
                    ->icon('heroicon-m-envelope')
                    ->searchable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Add New Guardian')
                    ->modalHeading('Create & Link New Guardian')
                    ->modalWidth('4xl'),

                AttachAction::make()
                    ->label('Link Existing Guardian')
                    ->modalHeading('Link Existing Guardian to Camper')
                    ->modalWidth('4xl')
                    ->preloadRecordSelect()
                    ->form(fn (AttachAction $action): array => [
                        Section::make('Select Guardian Profile')
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
