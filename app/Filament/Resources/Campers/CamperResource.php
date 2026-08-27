<?php

namespace App\Filament\Resources\Campers;

use App\Filament\Resources\Campers\Pages\CreateCamper;
use App\Filament\Resources\Campers\Pages\EditCamper;
use App\Filament\Resources\Campers\Pages\ListCampers;
use App\Filament\Resources\Campers\RelationManagers\DocumentsRelationManager;
use App\Filament\Resources\Campers\RelationManagers\GuardiansRelationManager;
use App\Filament\Resources\Campers\RelationManagers\RegistrationsRelationManager;
use App\Filament\Resources\Campers\Schemas\CamperForm;
use App\Filament\Resources\Campers\Schemas\CamperInfolist;
use App\Filament\Resources\Campers\Tables\CampersTable;
use App\Models\Camper;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CamperResource extends Resource
{
    protected static ?string $model = Camper::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $navigationLabel = 'Campers';

    protected static ?string $modelLabel = 'camper';

    protected static ?string $pluralModelLabel = 'campers';

    protected static UnitEnum|string|null $navigationGroup = 'People & Directory';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return CamperForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CampersTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CamperInfolist::configure($schema);
    }

    public static function getRelations(): array
    {
        return [
            GuardiansRelationManager::class,
            RegistrationsRelationManager::class,
            DocumentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCampers::route('/'),
            'create' => CreateCamper::route('/create'),
            'edit' => EditCamper::route('/{record}/edit'),
        ];
    }
}
