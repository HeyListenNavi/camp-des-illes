<?php

namespace App\Filament\Resources\GroupEvents\Schemas;

use App\Enums\GroupEventStatus;
use App\Models\GroupEvent;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class GroupEventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(['default' => 1, 'lg' => 2])
                    ->schema([
                        Section::make('Host Group & Primary Contact')
                            ->description('Contact and organization details of the applicant group.')
                            ->icon(Heroicon::OutlinedBuildingOffice2)
                            ->relationship('group')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Group / Event Name')
                                    ->prefixIcon(Heroicon::OutlinedBuildingOffice2)
                                    ->placeholder('e.g. Grace Fellowship Youth Retreat')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                TextInput::make('organization_name')
                                    ->label('Organization / Company')
                                    ->prefixIcon(Heroicon::OutlinedBriefcase)
                                    ->placeholder('e.g. Grace Community Church')
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                TextInput::make('primary_contact_name')
                                    ->label('Primary Contact Name')
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
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Textarea::make('address')
                                    ->label('Full Address')
                                    ->placeholder('e.g. 100 Church Street, Montreal')
                                    ->rows(3)
                                    ->autosize()
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->columnSpan(1),

                        Section::make('Event Schedule & Requirements')
                            ->description('Dates, capacity, and operational logistics.')
                            ->icon(Heroicon::OutlinedCalendarDays)
                            ->schema([
                                Select::make('status')
                                    ->label('Inquiry Request Status')
                                    ->options(GroupEventStatus::class)
                                    ->default(GroupEventStatus::InquiryReceived)
                                    ->native(false)
                                    ->required()
                                    ->columnSpanFull(),

                                DatePicker::make('start_date')
                                    ->label('Start Date')
                                    ->prefixIcon(Heroicon::OutlinedCalendar)
                                    ->native(false)
                                    ->required(),

                                DatePicker::make('end_date')
                                    ->label('End Date')
                                    ->prefixIcon(Heroicon::OutlinedCalendar)
                                    ->native(false)
                                    ->required()
                                    ->afterOrEqual('start_date'),

                                TextInput::make('expected_attendees')
                                    ->label('Expected Attendees')
                                    ->prefixIcon(Heroicon::OutlinedUserGroup)
                                    ->numeric()
                                    ->required()
                                    ->columnSpanFull(),

                                Textarea::make('operational_notes')
                                    ->label('Operational Notes & Special Requests')
                                    ->placeholder('Specify lodging, dining, audio/visual, or custom activity requirements...')
                                    ->rows(3)
                                    ->autosize()
                                    ->columnSpanFull(),

                                TextInput::make('public_link')
                                    ->label('Public Access Link')
                                    ->prefixIcon(Heroicon::OutlinedLink)
                                    ->formatStateUsing(fn (?GroupEvent $record): ?string => $record?->token ? url("/public/group-request?token={$record->token}") : null)
                                    ->placeholder('Link generated automatically upon saving')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->copyable()
                                    ->suffixAction(
                                        Action::make('openPublicLink')
                                            ->icon('heroicon-m-arrow-top-right-on-square')
                                            ->tooltip('Open public portal link in new tab')
                                            ->url(fn (?string $state): ?string => $state, shouldOpenInNewTab: true)
                                            ->visible(fn (?string $state): bool => ! empty($state))
                                    )
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->columnSpan(1),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
