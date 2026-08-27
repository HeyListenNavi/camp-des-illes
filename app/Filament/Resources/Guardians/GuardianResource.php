<?php

namespace App\Filament\Resources\Guardians;

use App\Filament\Resources\Guardians\Pages\CreateGuardian;
use App\Filament\Resources\Guardians\Pages\EditGuardian;
use App\Filament\Resources\Guardians\Pages\ListGuardians;
use App\Filament\Resources\Guardians\Pages\ViewGuardian;
use App\Filament\Resources\Guardians\Schemas\GuardianForm;
use App\Filament\Resources\Guardians\Schemas\GuardianInfolist;
use App\Filament\Resources\Guardians\Tables\GuardiansTable;
use App\Models\Guardian;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class GuardianResource extends Resource
{
    protected static ?string $model = Guardian::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $navigationLabel = 'Tutores';

    protected static ?string $modelLabel = 'tutor';

    protected static ?string $pluralModelLabel = 'tutores';

    protected static UnitEnum|string|null $navigationGroup = 'Personas';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return GuardianForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GuardiansTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return GuardianInfolist::configure($schema);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\CampersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGuardians::route('/'),
            'create' => CreateGuardian::route('/create'),
            'edit' => EditGuardian::route('/{record}/edit'),
        ];
    }
}