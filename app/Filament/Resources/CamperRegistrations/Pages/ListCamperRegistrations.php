<?php

namespace App\Filament\Resources\CamperRegistrations\Pages;

use App\Filament\Resources\CamperRegistrations\CamperRegistrationResource;
use App\Filament\Resources\CamperRegistrations\Widgets\RegistrationStatsOverview;
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

    protected function getHeaderWidgets(): array
    {
        return [
            RegistrationStatsOverview::class,
        ];
    }
}
