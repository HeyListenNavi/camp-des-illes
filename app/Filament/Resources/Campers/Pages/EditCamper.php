<?php

namespace App\Filament\Resources\Campers\Pages;

use App\Filament\Resources\Campers\CamperResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCamper extends EditRecord
{
    protected static string $resource = CamperResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
