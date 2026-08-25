<?php

namespace App\Filament\Resources\GuestGroupResource\Pages;

use App\Filament\Resources\GuestGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGuestGroups extends ListRecords
{
    protected static string $resource = GuestGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
