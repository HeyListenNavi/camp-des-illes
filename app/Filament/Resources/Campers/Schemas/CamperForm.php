<?php

namespace App\Filament\Resources\Campers\Schemas;

use App\Enums\Gender;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class CamperForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(['default' => 1, 'lg' => 3])
                    ->schema([
                        Grid::make(1)
                            ->schema([
                                Section::make('Personal Information')
                                    ->description('Camper identity and birth details.')
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
                                                ->required()
                                                ->maxDate(now()),
                                        ]),
                                    ]),

                                Section::make('Medical Profile')
                                    ->description('Health card details, allergies, and dietary needs.')
                                    ->icon(Heroicon::OutlinedHeart)
                                    ->schema([
                                        TextInput::make('health_card_number')
                                            ->label('Health Card / Insurance Number')
                                            ->prefixIcon(Heroicon::OutlinedCreditCard)
                                            ->maxLength(255)
                                            ->columnSpanFull(),

                                        Fieldset::make('Clinical Details')
                                            ->relationship('medical')
                                            ->schema([
                                                Textarea::make('allergies')
                                                    ->label('Known Allergies')
                                                    ->placeholder('e.g. Penicillin, Peanuts, Bee stings...')
                                                    ->rows(2)
                                                    ->autosize(),

                                                Textarea::make('medications')
                                                    ->label('Current Medications')
                                                    ->placeholder('e.g. Inhaler as needed, EpiPen...')
                                                    ->rows(2)
                                                    ->autosize(),

                                                Textarea::make('dietary_restrictions')
                                                    ->label('Dietary Restrictions')
                                                    ->placeholder('e.g. Vegetarian, Gluten-Free...')
                                                    ->rows(2)
                                                    ->autosize()
                                                    ->columnSpanFull(),
                                            ])
                                            ->columns(2)
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Residential Address')
                                    ->description('Home address.')
                                    ->icon(Heroicon::OutlinedHome)
                                    ->schema([
                                        Textarea::make('address')
                                            ->label('Full Address')
                                            ->rows(2)
                                            ->autosize()
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpan(['default' => 1, 'lg' => 2]),

                        Grid::make(1)
                            ->schema([
                                Section::make('Critical Health Alerts')
                                    ->description('Emergency clinical flags')
                                    ->icon(Heroicon::OutlinedExclamationTriangle)
                                    ->schema([
                                        Fieldset::make('Emergency Flags')
                                            ->relationship('medical')
                                            ->schema([
                                                Textarea::make('critical_alerts')
                                                    ->label('Critical Medical Flags')
                                                    ->placeholder('Highlight severe medical conditions or severe allergy instructions...')
                                                    ->rows(3)
                                                    ->autosize()
                                                    ->columnSpanFull(),
                                            ]),
                                    ]),

                                Section::make('Custody & Authorized Pickup')
                                    ->description('Child release & legal notes')
                                    ->icon(Heroicon::OutlinedShieldCheck)
                                    ->schema([
                                        Textarea::make('custody_details')
                                            ->label('Custody Notes & Restrictions')
                                            ->placeholder('List individuals authorized or restricted from picking up the camper...')
                                            ->helperText('Special instructions regarding pickup and release of minor.')
                                            ->rows(3)
                                            ->autosize()
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpan(['default' => 1, 'lg' => 1]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
