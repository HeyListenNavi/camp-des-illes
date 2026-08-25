<?php

namespace App\Filament\Resources\CamperResource\Pages;

use App\Filament\Resources\CamperResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCampers extends ListRecords
{
    protected static string $resource = CamperResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
