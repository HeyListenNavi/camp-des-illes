<?php

namespace App\Filament\Resources\Campers\Pages;

use App\Filament\Resources\Campers\CamperResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCampers extends ListRecords
{
    protected static string $resource = CamperResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
