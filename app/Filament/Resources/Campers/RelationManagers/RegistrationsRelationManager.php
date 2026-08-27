<?php

namespace App\Filament\Resources\Campers\RelationManagers;

use App\Enums\RegistrationStatus;
use App\Models\CamperRegistration;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RegistrationsRelationManager extends RelationManager
{
    protected static string $relationship = 'registrations';

    protected static ?string $title = 'Camp Registrations';

    protected static ?string $modelLabel = 'registration';

    protected static ?string $pluralModelLabel = 'registrations';

    protected static \BackedEnum|string|null $icon = Heroicon::OutlinedClipboardDocumentCheck;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('camp_event_id')
                    ->label('Camp Session Event')
                    ->relationship('campEvent', 'name')
                    ->searchable()
                    ->native(false)
                    ->required(),

                Select::make('status')
                    ->label('Registration Status')
                    ->options(RegistrationStatus::class)
                    ->native(false)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitle(fn (CamperRegistration $record) => $record->campEvent ? $record->campEvent->name : "Registration #{$record->id}")
            ->heading('Camp Registrations')
            ->columns([
                TextColumn::make('campEvent.name')
                    ->label('Camp Event')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-sparkles')
                    ->iconColor('primary')
                    ->weight('bold'),

                TextColumn::make('campEvent.year')
                    ->label('Year')
                    ->badge()
                    ->color('gray')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Registration Date')
                    ->dateTime('M j, Y g:i A')
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('New Camp Registration'),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ]);
    }
}
