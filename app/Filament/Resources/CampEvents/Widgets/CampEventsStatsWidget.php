<?php

namespace App\Filament\Resources\CampEvents\Widgets;

use App\Models\CamperRegistration;
use App\Models\CampEvent;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CampEventsStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalEvents = CampEvent::count();
        $activeSessions = CampEvent::where('is_active', true)->count();
        $totalCampers = CamperRegistration::count();

        return [
            Stat::make('Total Camp Sessions', $totalEvents)
                ->description('All recorded events')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('gray'),

            Stat::make('Active Camp Sessions', $activeSessions)
                ->description('Currently open for registration')
                ->descriptionIcon('heroicon-m-sparkles')
                ->color('success'),

            Stat::make('Total Registered Campers', $totalCampers)
                ->description('Enrolled across all sessions')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),
        ];
    }
}
