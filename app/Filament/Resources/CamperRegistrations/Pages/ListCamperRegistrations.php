<?php

namespace App\Filament\Resources\CamperRegistrations\Pages;

use App\Filament\Resources\CamperRegistrations\CamperRegistrationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCamperRegistrations extends ListRecords
{
    protected static string $resource = CamperRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
