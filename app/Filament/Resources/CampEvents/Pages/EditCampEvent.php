<?php

namespace App\Filament\Resources\CampEvents\Pages;

use App\Filament\Resources\CampEvents\CampEventResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCampEvent extends EditRecord
{
    protected static string $resource = CampEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
