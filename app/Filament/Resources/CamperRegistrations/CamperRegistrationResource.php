<?php

namespace App\Filament\Resources\CamperRegistrations;

use App\Filament\Resources\CamperRegistrations\Pages\CreateCamperRegistration;
use App\Filament\Resources\CamperRegistrations\Pages\EditCamperRegistration;
use App\Filament\Resources\CamperRegistrations\Pages\ListCamperRegistrations;
use App\Filament\Resources\CamperRegistrations\Schemas\CamperRegistrationForm;
use App\Filament\Resources\CamperRegistrations\Tables\CamperRegistrationsTable;
use App\Models\CamperRegistration;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CamperRegistrationResource extends Resource
{
    protected static ?string $model = CamperRegistration::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?string $navigationLabel = 'Camper Registrations';

    protected static ?string $modelLabel = 'camper registration';

    protected static ?string $pluralModelLabel = 'camper registrations';

    protected static UnitEnum|string|null $navigationGroup = 'Camp Operations';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return CamperRegistrationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CamperRegistrationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCamperRegistrations::route('/'),
            'create' => CreateCamperRegistration::route('/create'),
            'edit' => EditCamperRegistration::route('/{record}/edit'),
        ];
    }
}
