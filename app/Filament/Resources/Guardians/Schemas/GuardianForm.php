<?php

namespace App\Filament\Resources\Guardians\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class GuardianForm
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
                                    ->description('Guardian contact information and identity.')
                                    ->icon(Heroicon::OutlinedIdentification)
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
                                    ]),

                                Section::make('Residential Address')
                                    ->description('Home and mailing address.')
                                    ->icon(Heroicon::OutlinedHome)
                                    ->schema([
                                        Textarea::make('address')
                                            ->label('Full Address')
                                            ->placeholder('e.g. 123 Camp Road, Suite 400, Quebec')
                                            ->rows(3)
                                            ->autosize()
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpan(['default' => 1, 'lg' => 2]),

                        Grid::make(1)
                            ->schema([
                                Section::make('Legal & Custody Status')
                                    ->description('Custody rights and access authorization')
                                    ->icon(Heroicon::OutlinedShieldCheck)
                                    ->schema([
                                        Toggle::make('has_custody')
                                            ->label('Legal Custody Rights')
                                            ->helperText('Indicates whether this guardian holds legal custody rights for their registered campers.')
                                            ->default(true),
                                    ]),
                            ])
                            ->columnSpan(['default' => 1, 'lg' => 1]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
