<?php

namespace App\Filament\Resources\CamperRegistrations\Pages;

use App\Filament\Resources\CamperRegistrations\CamperRegistrationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCamperRegistration extends EditRecord
{
    protected static string $resource = CamperRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
