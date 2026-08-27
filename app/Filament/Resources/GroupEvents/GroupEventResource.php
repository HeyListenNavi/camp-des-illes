<?php

namespace App\Filament\Resources\GroupEvents;

use App\Filament\Resources\GroupEvents\Pages\CreateGroupEvent;
use App\Filament\Resources\GroupEvents\Pages\EditGroupEvent;
use App\Filament\Resources\GroupEvents\Pages\ListGroupEvents;
use App\Filament\Resources\GroupEvents\RelationManagers\DocumentsRelationManager;
use App\Filament\Resources\GroupEvents\RelationManagers\ServiceRequestsRelationManager;
use App\Filament\Resources\GroupEvents\Schemas\GroupEventForm;
use App\Filament\Resources\GroupEvents\Tables\GroupEventsTable;
use App\Models\GroupEvent;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class GroupEventResource extends Resource
{
    protected static ?string $model = GroupEvent::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static ?string $navigationLabel = 'Solicitudes de Grupos';

    protected static ?string $modelLabel = 'solicitud de grupo';

    protected static ?string $pluralModelLabel = 'solicitudes de grupos';

    protected static UnitEnum|string|null $navigationGroup = 'Eventos';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return GroupEventForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GroupEventsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ServiceRequestsRelationManager::class,
            DocumentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGroupEvents::route('/'),
            'create' => CreateGroupEvent::route('/create'),
            'edit' => EditGroupEvent::route('/{record}/edit'),
        ];
    }
}
