<?php

namespace App\Filament\Resources\CampEvents\RelationManagers;

use App\Enums\Gender;
use App\Enums\RegistrationStatus;
use App\Models\CamperRegistration;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RegistrationsRelationManager extends RelationManager
{
    protected static string $relationship = 'registrations';

    protected static ?string $title = 'Camper Registrations';

    protected static \BackedEnum|string|null $icon = Heroicon::OutlinedUserGroup;

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Camper Profile')
                ->description('Personal details and health information for this camper.')
                ->icon(Heroicon::OutlinedUser)
                ->relationship('camper')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('first_name')
                            ->label('First Name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('last_name')
                            ->label('Last Name')
                            ->required()
                            ->maxLength(255),
                    ]),

                    Grid::make(3)->schema([
                        Select::make('gender')
                            ->label('Gender')
                            ->options(Gender::class)
                            ->native(false)
                            ->required(),

                        DatePicker::make('date_of_birth')
                            ->label('Date of Birth')
                            ->native(false),

                        TextInput::make('health_card_number')
                            ->label('Health Card Number')
                            ->maxLength(255),
                    ]),

                    TextInput::make('address')
                        ->label('Address')
                        ->columnSpanFull()
                        ->maxLength(255),

                    Textarea::make('custody_details')
                        ->label('Custody & Special Notes')
                        ->columnSpanFull()
                        ->rows(2)
                        ->autosize(),
                ])
                ->columnSpanFull(),

            Section::make('Registration Details')
                ->icon(Heroicon::OutlinedClipboardDocumentCheck)
                ->schema([
                    Select::make('status')
                        ->label('Registration Status')
                        ->options(RegistrationStatus::class)
                        ->native(false)
                        ->required()
                        ->columnSpanFull(),
                ])
                ->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitle(fn (CamperRegistration $record) => $record->camper ? "{$record->camper->first_name} {$record->camper->last_name}" : "Registration #{$record->id}")
            ->heading('Registered Campers')
            ->columns([
                TextColumn::make('camper.first_name')
                    ->label('Camper Full Name')
                    ->formatStateUsing(fn (CamperRegistration $record) => $record->camper ? $record->camper->first_name.' '.$record->camper->last_name : 'N/A')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('status')
                    ->label('Registration Status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Registration Date')
                    ->dateTime('M j, Y g:i A')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter by Status')
                    ->options(RegistrationStatus::class)
                    ->native(false),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make()
                        ->modalHeading('Registration Details'),
                    EditAction::make()
                        ->modalHeading('Edit Registration'),
                    DeleteAction::make(),
                ]),
            ]);
    }
}
