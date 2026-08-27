<?php

namespace App\Filament\Resources\CampEvents;

use App\Filament\Resources\CampEvents\Pages\CreateCampEvent;
use App\Filament\Resources\CampEvents\Pages\EditCampEvent;
use App\Filament\Resources\CampEvents\Pages\ListCampEvents;
use App\Filament\Resources\CampEvents\RelationManagers\RegistrationsRelationManager;
use App\Filament\Resources\CampEvents\Schemas\CampEventForm;
use App\Filament\Resources\CampEvents\Tables\CampEventsTable;
use App\Models\CampEvent;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CampEventResource extends Resource
{
    protected static ?string $model = CampEvent::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $navigationLabel = 'Camp Events';

    protected static ?string $modelLabel = 'Camp Event';

    protected static ?string $pluralModelLabel = 'Camp Events';

    protected static UnitEnum|string|null $navigationGroup = 'Camp Operations';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return CampEventForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CampEventsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RegistrationsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCampEvents::route('/'),
            'create' => CreateCampEvent::route('/create'),
            'edit' => EditCampEvent::route('/{record}/edit'),
        ];
    }
}
