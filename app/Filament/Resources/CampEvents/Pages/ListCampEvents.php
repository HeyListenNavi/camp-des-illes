<?php

namespace App\Filament\Resources\CampEvents\Pages;

use App\Filament\Resources\CampEvents\CampEventResource;
use App\Filament\Resources\CampEvents\Widgets\CampEventsStatsWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCampEvents extends ListRecords
{
    protected static string $resource = CampEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New Camp Event')
                ->icon('heroicon-m-plus'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CampEventsStatsWidget::class,
        ];
    }
}
