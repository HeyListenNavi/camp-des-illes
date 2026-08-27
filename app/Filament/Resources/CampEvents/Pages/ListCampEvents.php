<?php

namespace App\Filament\Resources\CampEvents\Pages;

use App\Filament\Resources\CampEvents\CampEventResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCampEvents extends ListRecords
{
    protected static string $resource = CampEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
