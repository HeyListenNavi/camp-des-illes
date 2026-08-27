<?php

namespace App\Filament\Resources\CampEvents\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class CampEventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(['default' => 1, 'lg' => 2])
                    ->schema([
                        Section::make('General Information')
                            ->description('Event title, session year, and registration availability.')
                            ->icon(Heroicon::OutlinedInformationCircle)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Camp Event Name')
                                    ->placeholder('e.g. Youth Summer Camp 2026')
                                    ->prefixIcon(Heroicon::OutlinedSparkles)
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Select::make('year')
                                    ->label('Session Year')
                                    ->options(function () {
                                        $current = (int) date('Y');
                                        $years = range($current - 5, $current + 5);

                                        return array_combine($years, $years);
                                    })
                                    ->default((int) date('Y'))
                                    ->native(false)
                                    ->required(),

                                Toggle::make('is_active')
                                    ->label('Active Camp Session')
                                    ->helperText(
                                        'Enable to mark this session active and open for camper registrations.'
                                    )
                                    ->default(true),
                            ])
                            ->columnSpan(1),

                        Section::make('Schedule & Dates')
                            ->description('Session start and end date configuration.')
                            ->icon(Heroicon::OutlinedCalendarDays)
                            ->schema([
                                DatePicker::make('start_date')
                                    ->label('Start Date')
                                    ->prefixIcon(Heroicon::OutlinedCalendar)
                                    ->required()
                                    ->native(false),

                                DatePicker::make('end_date')
                                    ->label('End Date')
                                    ->prefixIcon(Heroicon::OutlinedCalendar)
                                    ->required()
                                    ->afterOrEqual('start_date')
                                    ->native(false),
                            ])
                            ->columnSpan(1),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
