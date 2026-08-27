<?php

namespace App\Filament\Resources\Campers\Widgets;

use App\Models\Camper;
use App\Models\CamperMedical;
use App\Models\CamperRegistration;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CamperStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalCampers = Camper::count();
        $activeRegistrations = CamperRegistration::where('status', 'confirmed')->count();
        $medicalAlerts = CamperMedical::where(function ($query) {
            $query->whereNotNull('allergies')->where('allergies', '!=', '');
        })->orWhere(function ($query) {
            $query->whereNotNull('critical_alerts')->where('critical_alerts', '!=', '');
        })->count();

        return [
            Stat::make('Total Registered Campers', (string) $totalCampers)
                ->description('Campers in system database')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),

            Stat::make('Confirmed Registrations', (string) $activeRegistrations)
                ->description('Active session registrations')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Medical / Allergy Flags', (string) $medicalAlerts)
                ->description('Campers requiring clinical attention')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('warning'),
        ];
    }
}
