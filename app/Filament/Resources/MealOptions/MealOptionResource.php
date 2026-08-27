<?php

namespace App\Filament\Resources\MealOptions;

use App\Filament\Resources\MealOptions\Pages\CreateMealOption;
use App\Filament\Resources\MealOptions\Pages\EditMealOption;
use App\Filament\Resources\MealOptions\Pages\ListMealOptions;
use App\Filament\Resources\MealOptions\Schemas\MealOptionForm;
use App\Filament\Resources\MealOptions\Tables\MealOptionsTable;
use App\Models\MealOption;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;


class MealOptionResource extends Resource
{
    protected static ?string $model = MealOption::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedSparkles; 
   
    protected static UnitEnum|string|null $navigationGroup = 'Catalog';

    public static function form(Schema $schema): Schema
    {
        return MealOptionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MealOptionsTable::configure($table);
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
            'index' => ListMealOptions::route('/'),
            'create' => CreateMealOption::route('/create'),
            'edit' => EditMealOption::route('/{record}/edit'),
        ];
    }
}
