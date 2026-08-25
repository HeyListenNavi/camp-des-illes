<?php

namespace App\Filament\Resources\GuestGroupResource\Pages;

use App\Filament\Resources\GuestGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGuestGroup extends EditRecord
{
    protected static string $resource = GuestGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
