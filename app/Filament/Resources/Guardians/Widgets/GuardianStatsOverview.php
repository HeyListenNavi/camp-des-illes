<?php

namespace App\Filament\Resources\Guardians\Widgets;

use App\Models\Guardian;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class GuardianStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalGuardians = Guardian::count();
        $primaryGuardians = DB::table('camper_guardian')->where('is_primary_guardian', true)->distinct('guardian_id')->count('guardian_id');
        $emergencyContacts = DB::table('camper_guardian')->where('is_emergency_contact', true)->distinct('guardian_id')->count('guardian_id');

        return [
            Stat::make('Total Guardians', (string) $totalGuardians)
                ->description('Parent & guardian directory')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Primary Guardians', (string) $primaryGuardians)
                ->description('Designated primary contacts')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('success'),

            Stat::make('Emergency Contacts', (string) $emergencyContacts)
                ->description('Authorized emergency contacts')
                ->descriptionIcon('heroicon-m-phone-arrow-up-right')
                ->color('info'),
        ];
    }
}
